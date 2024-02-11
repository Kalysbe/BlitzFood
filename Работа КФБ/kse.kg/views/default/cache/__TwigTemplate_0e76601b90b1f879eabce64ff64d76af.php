<?php

/* modules/Tradestat/Tradestat.html */
class __TwigTemplate_0e76601b90b1f879eabce64ff64d76af extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<h2>";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "Last Trade Results", array(), "array");
        echo "</h2>
<br /><br />
<div id=\"tradestat_last\" class=\"tradestat_table\">
    <h3 class=\"tradeResult_date\">";
        // line 4
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "Trades for", array(), "array");
        echo " ";
        echo (isset($context['Date']) ? $context['Date'] : null);
        echo "</h3>
    <table class=\"class1\" width=\"100%\">
        <tr>
            <th width=\"*\"></th>
            <th width=\"23%\">";
        // line 8
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{MlnSom}", array(), "array");
        echo "</th>
            <th width=\"23%\">%</th>
            <th width=\"5%\"></th>
        </tr>
        <tr class=\"tradeResult\">
            <td>";
        // line 13
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Trades Volume}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 14
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "TotalVolume", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 15
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "TotalVolumePercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 16
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "TotalVolumeImage", array(), "array");
        echo "</td>
        </tr>
        <tr class=\"tradeResult\">
            <td>";
        // line 19
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Primary Market}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 20
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "Primary", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 21
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "PrimaryPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 22
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "PrimaryImage", array(), "array");
        echo "</td>
        </tr>
        <tr class=\"tradeResult\">
            <td>";
        // line 25
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Secondary Market}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 26
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "Secondary", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 27
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "SecondaryPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 28
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "SecondaryImage", array(), "array");
        echo "</td>
        </tr>
        <tr class=\"tradeResult\">
            <td>";
        // line 31
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Listing}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 32
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "Listing", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 33
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "ListingPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 34
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "ListingImage", array(), "array");
        echo "</td>
        </tr>
        <tr class=\"tradeResult\">
            <td>";
        // line 37
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Non Listing}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 38
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "NonListing", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 39
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "NonListingPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 40
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "NonListingImage", array(), "array");
        echo "</td>
        </tr>
    </table>
    <BR>
    <table class=\"class5\" width=\"100%\" border=\"1\" cellpadding=\"3\" cellspacing=\"1\">

        <TR>
            <TH>";
        // line 47
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "curname", array(), "array");
        echo "</TH>
            <th>ISIN</th>
            <TH>";
        // line 49
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradesymbol", array(), "array");
        echo "</TH>
            <TH>";
        // line 50
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "maxprice", array(), "array");
        echo "</TH>
            <TH>";
        // line 51
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "minprice", array(), "array");
        echo "</TH>
            <TH>";
        // line 52
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradevolume", array(), "array");
        echo "</TH>
            <TH>";
        // line 53
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "amountoftransactions", array(), "array");
        echo "</TH>
            <TH>";
        // line 54
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "amountofsecurities", array(), "array");
        echo "</TH>
        </TR>
        ";
        // line 56
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['TradeLast']) ? $context['TradeLast'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['my_cur_row']) {
            echo "
        <TR class=\"company_trade\">
            <TD align=\"left\">";
            // line 58
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "NameRus", array(), "array");
            echo "</TD>
            <TD align=\"left\">";
            // line 59
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "isin", array(), "array");
            echo "</TD>
            <TD class=\"center\" title=\"";
            // line 60
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "NameRus", array(), "array");
            echo "\" style=\"cursor: help\">";
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "ShortName", array(), "array");
            echo "</TD>
            <TD align=\"right\">";
            // line 61
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "MaxCost", array(), "array");
            echo "</TD>
            <TD align=\"right\">";
            // line 62
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "MinCost", array(), "array");
            echo "</TD>
            <TD align=\"right\">";
            // line 63
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "Total_Volume", array(), "array");
            echo "</TD>
            <TD align=\"right\">";
            // line 64
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "CountDeal", array(), "array");
            echo "</TD>
            <TD align=\"right\">";
            // line 65
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "CountInstr", array(), "array");
            echo "</TD>
        </TR>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['my_cur_row'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 67
        echo "
    </TABLE>

</div>

<div id=\"tradestat_week\" class=\"tradestat_table\" style=\"display: none;\">
    <h3>";
        // line 73
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "Forweek", array(), "array");
        echo " (";
        echo (isset($context['week_interval']) ? $context['week_interval'] : null);
        echo ")</h3>
    <table class=\"class1\" width=\"100%\">
        <tr>
            <th width=\"*\"></th>
            <th width=\"23%\">";
        // line 77
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{MlnSom}", array(), "array");
        echo "</th>
            <th width=\"23%\">%</th>
            <th width=\"5%\"></th>
        </tr>
        <tr>
            <td>";
        // line 82
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Trades Volume}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 83
        echo $this->getAttribute((isset($context['Week']) ? $context['Week'] : null), "TotalVolume", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 84
        echo $this->getAttribute((isset($context['Week']) ? $context['Week'] : null), "TotalVolumePercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 85
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "TotalVolumeImage", array(), "array");
        echo "</td>
        </tr>
        <tr>
            <td>";
        // line 88
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Primary Market}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 89
        echo $this->getAttribute((isset($context['Week']) ? $context['Week'] : null), "Primary", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 90
        echo $this->getAttribute((isset($context['Week']) ? $context['Week'] : null), "PrimaryPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 91
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "PrimaryImage", array(), "array");
        echo "</td>
        </tr>
        <tr>
            <td>";
        // line 94
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Secondary Market}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 95
        echo $this->getAttribute((isset($context['Week']) ? $context['Week'] : null), "Secondary", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 96
        echo $this->getAttribute((isset($context['Week']) ? $context['Week'] : null), "SecondaryPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 97
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "SecondaryImage", array(), "array");
        echo "</td>
        </tr>
        <tr>
            <td>";
        // line 100
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Listing}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 101
        echo $this->getAttribute((isset($context['Week']) ? $context['Week'] : null), "Listing", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 102
        echo $this->getAttribute((isset($context['Week']) ? $context['Week'] : null), "ListingPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 103
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "ListingImage", array(), "array");
        echo "</td>
        </tr>
        <tr>
            <td>";
        // line 106
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Non Listing}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 107
        echo $this->getAttribute((isset($context['Week']) ? $context['Week'] : null), "NonListing", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 108
        echo $this->getAttribute((isset($context['Week']) ? $context['Week'] : null), "NonListingPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 109
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "NonListingImage", array(), "array");
        echo "</td>
        </tr>
    </table>
    <br>

    <table class=\"class5\" width=\"100%\" border=\"1\" cellpadding=\"3\" cellspacing=\"1\">

        <TR>
            <TH>";
        // line 117
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "curname", array(), "array");
        echo "</TH>
            <TH>ISIN</TH>
            <TH>";
        // line 119
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradesymbol", array(), "array");
        echo "</TH>
            <TH>";
        // line 120
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "maxprice", array(), "array");
        echo "</TH>
            <TH>";
        // line 121
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "minprice", array(), "array");
        echo "</TH>
            <TH>";
        // line 122
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradevolume", array(), "array");
        echo "</TH>
            <TH>";
        // line 123
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "amountoftransactions", array(), "array");
        echo "</TH>
            <TH>";
        // line 124
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "amountofsecurities", array(), "array");
        echo "</TH>
        </TR>
        ";
        // line 126
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['TradeWeek']) ? $context['TradeWeek'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['my_cur_row']) {
            echo "
        <TR>
            <TD align=\"left\">";
            // line 128
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "NameRus", array(), "array");
            echo "</TD>
            <TD align=\"center\">";
            // line 129
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "isin", array(), "array");
            echo "</TD>
            <TD class=\"center\" title=\"";
            // line 130
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "NameRus", array(), "array");
            echo "\" style=\"cursor: help\">";
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "ShortName", array(), "array");
            echo "</TD>
            <TD align=\"right\">";
            // line 131
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "MaxCost", array(), "array");
            echo "</TD>
            <TD align=\"right\">";
            // line 132
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "MinCost", array(), "array");
            echo "</TD>
            <TD align=\"right\">";
            // line 133
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "Total_Volume", array(), "array");
            echo "</TD>
            <TD align=\"right\">";
            // line 134
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "CountDeal", array(), "array");
            echo "</TD>
            <TD align=\"right\">";
            // line 135
            echo $this->getAttribute((isset($context['my_cur_row']) ? $context['my_cur_row'] : null), "CountInstr", array(), "array");
            echo "</TD>
        </TR>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['my_cur_row'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 137
        echo "
    </TABLE>

    ";
        // line 140
        echo (isset($context['WeekChart']) ? $context['WeekChart'] : null);
        echo "
</div>

<div id=\"tradestat_month\" class=\"tradestat_table\" style=\"display: none;\">
    <h3>";
        // line 144
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "For", array(), "array");
        echo " ";
        echo (isset($context['month_name']) ? $context['month_name'] : null);
        echo " ";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "month", array(), "array");
        echo "</h3>
    <table class=\"class1\" width=\"100%\">
        <tr>
            <th width=\"*\"></th>
            <th width=\"23%\">";
        // line 148
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{MlnSom}", array(), "array");
        echo "</th>
            <th width=\"23%\">%</th>
            <th width=\"5%\"></th>
        </tr>
        <tr>
            <td>";
        // line 153
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Trades Volume}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 154
        echo $this->getAttribute((isset($context['Month']) ? $context['Month'] : null), "TotalVolume", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 155
        echo $this->getAttribute((isset($context['Month']) ? $context['Month'] : null), "TotalVolumePercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 156
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "TotalVolumeImage", array(), "array");
        echo "</td>
        </tr>
        <tr>
            <td>";
        // line 159
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Primary Market}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 160
        echo $this->getAttribute((isset($context['Month']) ? $context['Month'] : null), "Primary", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 161
        echo $this->getAttribute((isset($context['Month']) ? $context['Month'] : null), "PrimaryPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 162
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "PrimaryImage", array(), "array");
        echo "</td>
        </tr>
        <tr>
            <td>";
        // line 165
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Secondary Market}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 166
        echo $this->getAttribute((isset($context['Month']) ? $context['Month'] : null), "Secondary", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 167
        echo $this->getAttribute((isset($context['Month']) ? $context['Month'] : null), "SecondaryPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 168
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "SecondaryImage", array(), "array");
        echo "</td>
        </tr>
        <tr>
            <td>";
        // line 171
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Listing}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 172
        echo $this->getAttribute((isset($context['Month']) ? $context['Month'] : null), "Listing", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 173
        echo $this->getAttribute((isset($context['Month']) ? $context['Month'] : null), "ListingPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 174
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "ListingImage", array(), "array");
        echo "</td>
        </tr>
        <tr>
            <td>";
        // line 177
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Non Listing}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 178
        echo $this->getAttribute((isset($context['Month']) ? $context['Month'] : null), "NonListing", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 179
        echo $this->getAttribute((isset($context['Month']) ? $context['Month'] : null), "NonListingPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 180
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "NonListingImage", array(), "array");
        echo "</td>
        </tr>
    </table>
    <br> ";
        // line 183
        echo (isset($context['MonthChart']) ? $context['MonthChart'] : null);
        echo "

</div>

<div id=\"tradestat_year\" class=\"tradestat_table\" style=\"display: none;\">
    <h3>";
        // line 188
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "For", array(), "array");
        echo " ";
        echo (isset($context['YearName']) ? $context['YearName'] : null);
        echo " ";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "year", array(), "array");
        echo "</h3>
    <table class=\"class1\" width=\"100%\">
        <tr>
            <th width=\"*\"></th>
            <th width=\"23%\">";
        // line 192
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{MlnSom}", array(), "array");
        echo "</th>
            <th width=\"23%\">%</th>
            <th width=\"5%\"></th>
        </tr>
        <tr>
            <td>";
        // line 197
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Trades Volume}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 198
        echo $this->getAttribute((isset($context['Year']) ? $context['Year'] : null), "TotalVolume", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 199
        echo $this->getAttribute((isset($context['Year']) ? $context['Year'] : null), "TotalVolumePercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 200
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "TotalVolumeImage", array(), "array");
        echo "</td>
        </tr>
        <tr>
            <td>";
        // line 203
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Primary Market}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 204
        echo $this->getAttribute((isset($context['Year']) ? $context['Year'] : null), "Primary", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 205
        echo $this->getAttribute((isset($context['Year']) ? $context['Year'] : null), "PrimaryPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 206
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "PrimaryImage", array(), "array");
        echo "</td>
        </tr>
        <tr>
            <td>";
        // line 209
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Secondary Market}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 210
        echo $this->getAttribute((isset($context['Year']) ? $context['Year'] : null), "Secondary", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 211
        echo $this->getAttribute((isset($context['Year']) ? $context['Year'] : null), "SecondaryPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 212
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "SecondaryImage", array(), "array");
        echo "</td>
        </tr>
        <tr>
            <td>";
        // line 215
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Listing}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 216
        echo $this->getAttribute((isset($context['Year']) ? $context['Year'] : null), "Listing", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 217
        echo $this->getAttribute((isset($context['Year']) ? $context['Year'] : null), "ListingPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 218
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "ListingImage", array(), "array");
        echo "</td>
        </tr>
        <tr>
            <td>";
        // line 221
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Non Listing}", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 222
        echo $this->getAttribute((isset($context['Year']) ? $context['Year'] : null), "NonListing", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 223
        echo $this->getAttribute((isset($context['Year']) ? $context['Year'] : null), "NonListingPercent", array(), "array");
        echo "</td>
            <td class=\"center\">";
        // line 224
        echo $this->getAttribute((isset($context['Last']) ? $context['Last'] : null), "NonListingImage", array(), "array");
        echo "</td>
        </tr>
    </table>

    <br> ";
        // line 228
        echo (isset($context['YearChart']) ? $context['YearChart'] : null);
        echo "
</div>

<div class=\"results_view f_r\">
    ";
        // line 232
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Period}", array(), "array");
        echo "
    <a href=\"#\" onclick=\"return false;\" id=\"tradestat_last_link\" class=\"tradestat_links current\">";
        // line 233
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Last trade}", array(), "array");
        echo "</a> /
    <a href=\"#\" onclick=\"return false;\" id=\"tradestat_week_link\" class=\"tradestat_links\">";
        // line 234
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "Forweek", array(), "array");
        echo "</a> /
    <a href=\"#\" onclick=\"return false;\" id=\"tradestat_month_link\" class=\"tradestat_links\">";
        // line 235
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "Formonth", array(), "array");
        echo "</a> /
    <a href=\"#\" onclick=\"return false;\" id=\"tradestat_year_link\" class=\"tradestat_links\">";
        // line 236
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "Foryear", array(), "array");
        echo "</a>
</div>
<br><br>

<div id=\"chartdivMonth\" style=\"height:300px; display: none;\"></div>

<div id=\"chartdiv\" style=\"height:300px; display: none;\"></div>
<!--<p><b>Р СџРЎР‚Р С‘Р СР ВµРЎвЂЎР В°Р Р…Р С‘Р Вµ:</b> Р РЋР Т‘Р ВµР В»Р С”Р С‘ Р С•РЎвЂљР С•Р В±РЎР‚Р В°Р В¶Р В°Р ВµР СРЎвЂ№Р Вµ Р С—Р С• Р вЂњР С•РЎРѓРЎС“Р Т‘Р В°РЎР‚РЎРѓРЎвЂљР Р†Р ВµР Р…Р Р…РЎвЂ№Р С РЎвЂ Р ВµР Р…Р Р…РЎвЂ№Р С Р В±РЎС“Р СР В°Р С–Р В°Р С Р Р† Р ВРЎвЂљР С•Р С–Р В°РЎвЂ¦ Р С—Р С•РЎРѓР В»Р ВµР Т‘Р Р…Р С‘РЎвЂ¦ РЎвЂљР С•РЎР‚Р С–Р В°РЎвЂ¦ Р С—РЎР‚Р С•Р Р†Р С•Р Т‘Р С‘РЎвЂљРЎРѓРЎРЏ Р Р† РЎР‚Р В°Р СР В°Р С”Р В°РЎвЂ¦ РЎвЂљР ВµРЎРѓРЎвЂљР С‘РЎР‚Р С•Р Р†Р В°Р Р…Р С‘РЎРЏ Р Р† Р СћР РЋ.<p/> -->

<!-- partial:index.partial.html -->
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://www.kse.kg/views/kse/styles/chart.css\">
<script src=\"http://www.kse.kg/views/kse/js/chart.js\"></script>
<script src=\"http://www.kse.kg/views/kse/js/chart_1.js\"></script>

<!-- partial -->
<style type=\"text/css\">
    .amcharts-chart-div a {
        display: none!important;
    }
</style>
<script type=\"text/javascript\">
\t
    var chartData = [
    ";
        // line 259
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['TradeWeekChart']) ? $context['TradeWeekChart'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['WeekCharts']) {
            echo " {
    \t\"date\": ";
            // line 260
            echo $this->getAttribute((isset($context['WeekCharts']) ? $context['WeekCharts'] : null), "full_date", array(), "array");
            echo ",
        \"latitude\": ";
            // line 261
            echo $this->getAttribute((isset($context['WeekCharts']) ? $context['WeekCharts'] : null), "total_volume", array(), "array");
            echo ",
        \"distance\": ";
            // line 262
            echo $this->getAttribute((isset($context['WeekCharts']) ? $context['WeekCharts'] : null), "total_volume", array(), "array");
            echo ",
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['WeekCharts'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 264
        echo "

    ]; // График постороенный за неделю

    var chartDataMonth = [
    ";
        // line 269
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['TradeWeekChartMonth']) ? $context['TradeWeekChartMonth'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['WeekChartsMonth']) {
            echo " {
            \"date\": ";
            // line 270
            echo $this->getAttribute((isset($context['WeekChartsMonth']) ? $context['WeekChartsMonth'] : null), "full_date", array(), "array");
            echo ",
            \"latitude\": ";
            // line 271
            echo $this->getAttribute((isset($context['WeekChartsMonth']) ? $context['WeekChartsMonth'] : null), "total_volume", array(), "array");
            echo ",
            \"distance\": ";
            // line 272
            echo $this->getAttribute((isset($context['WeekChartsMonth']) ? $context['WeekChartsMonth'] : null), "total_volume", array(), "array");
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['WeekChartsMonth'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 275
        echo "

    ]; // График постороенный за неделю


    var chart = AmCharts.makeChart(\"chartdiv\", {
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
            title: \"Объем млн.сом\",
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
            type: \"column\",
            fillAlphas: 0.9,
            valueAxis: \"a1\",
            balloonText: \"[[value]] млн.сом\",
            lineColor: \"#4aa4e6\",
            alphaField: \"alpha\"
        }, {
            id: \"g2\",
            valueField: \"latitude\",
            classNameField: \"bulletClass\",
            title: \"latitude/city\",
            type: \"line\",
            valueAxis: \"a2\",
            lineColor: \"#000\",
            lineThickness: 1,
            bullet: \"round\",
            bulletBorderColor: \"#263138\",
            bulletBorderAlpha: 1,
            bulletBorderThickness: 2,
            bulletColor: \"#263138\",
            labelPosition: \"right\",
            balloonText: \"объем:[[value]]\",
            showBalloon: true,
            animationPlayed: true
        }],

        chartCursor: {
            zoomable: false,
            categoryBalloonDateFormat: \"DD-MM-YYYY\",
            cursorAlpha: 0,
            valueBalloonsEnabled: false
        }
    }); // Неделя

    var chart = AmCharts.makeChart(\"chartdivMonth\", {
        type: \"serial\",
        dataDateFormat: \"YYYY-MM-DD\",
        dataProvider: chartDataMonth,

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
            title: \"Объем млн.сом\",
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
            type: \"column\",
            fillAlphas: 0.9,
            valueAxis: \"a1\",
            balloonText: \"[[value]] млн.сом\",
            lineColor: \"#4aa4e6\",
            alphaField: \"alpha\",
        }, {
            id: \"g2\",
            valueField: \"latitude\",
            classNameField: \"bulletClass\",
            title: \"latitude/city\",
            type: \"line\",
            valueAxis: \"a2\",
            lineColor: \"#000\",
            lineThickness: 1,
            bullet: \"round\",
            bulletBorderColor: \"#263138\",
            bulletBorderAlpha: 1,
            bulletBorderThickness: 2,
            bulletColor: \"#263138\",
            labelPosition: \"right\",
            balloonText: \"объем:[[value]]\",
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
</script>



<script type=\"text/javascript\">
    \$(\"#tradestat_last_link\").bind(\"click\", function() {
        \$(\".tradestat_table\").css(\"display\", \"none\");
        \$(\"#tradestat_last\").css(\"display\", \"block\");
        \$(\".tradestat_links\").removeClass(\"current\");
        \$(\"#tradestat_last_link\").addClass(\"current\");
        \$(\"#chartdiv\").css(\"display\", \"none\");
        \$(\"#chartdivMonth\").css(\"display\", \"none\");
    });

    \$(\"#tradestat_week_link\").bind(\"click\", function() {
        \$(\".tradestat_table\").css(\"display\", \"none\");
        \$(\"#tradestat_week\").css(\"display\", \"block\");
        \$(\".tradestat_links\").removeClass(\"current\");
        \$(\"#tradestat_week_link\").addClass(\"current\");
        \$(\"#chartdiv\").css(\"display\", \"block\");
        \$(\"#chartdivMonth\").css(\"display\", \"none\");
    });

    \$(\"#tradestat_month_link\").bind(\"click\", function() {
        \$(\".tradestat_table\").css(\"display\", \"none\");
        \$(\"#tradestat_month\").css(\"display\", \"block\");
        \$(\".tradestat_links\").removeClass(\"current\");
        \$(\"#tradestat_month_link\").addClass(\"current\");
        \$(\"#chartdiv\").css(\"display\", \"none\");
        \$(\"#chartdivMonth\").css(\"display\", \"block\");
    });

    \$(\"#tradestat_year_link\").bind(\"click\", function() {
        \$(\".tradestat_table\").css(\"display\", \"none\");
        \$(\"#tradestat_year\").css(\"display\", \"block\");
        \$(\".tradestat_links\").removeClass(\"current\");
        \$(\"#tradestat_year_link\").addClass(\"current\");
        \$(\"#chartdiv\").css(\"display\", \"none\");
        \$(\"#chartdivMonth\").css(\"display\", \"none\");
    });
</script>";
    }

}
