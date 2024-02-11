<?php

/* modules/Listingeng/Details.html */
class __TwigTemplate_1a525147257d615065aafbfe4efe8a6e extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        if ((isset($context['ListingError']) ? $context['ListingError'] : null)) {
            echo "

<div class=\"error ui-corner-all\">
    ";
            // line 4
            echo (isset($context['ListingError']) ? $context['ListingError'] : null);
            echo "
</div>

";
        } else {
            // line 7
            echo "

<table class=\"class1\" width=\"45%\" style=\"float: left;\">
    <tr>
        <th>General Information</th>
        <th>&nbsp;</th>
    </tr>
    <tr>
        <td>Name of the company</td>
        <td>";
            // line 16
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "CompanyName_eng", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Stock/Security</td>
        <td>";
            // line 20
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Security_eng", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Trade symbol</td>
        <td>";
            // line 24
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Symbols", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Industry</td>
        <td>";
            // line 28
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Sphere_eng", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Kind of activity</td>
        <td>";
            // line 32
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Activity_eng", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Date of passage of listing </td>
        <td>";
            // line 36
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "ListingDate", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Name of the head</td>
        <td>";
            // line 40
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Owner_eng", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Post of the head </td>
        <td>";
            // line 44
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "OwnerPosition_eng", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Address</td>
        <td>";
            // line 48
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Address_eng", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Telephone/Fax </td>
        <td>";
            // line 52
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Phone", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Auditor </td>
        <td>";
            // line 56
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Auditor_eng", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Registrar </td>
        <td>";
            // line 60
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Registrar_eng", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Market-maker </td>
        <td>";
            // line 64
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "MarketMaker_eng", array(), "array");
            echo "</td>
    </tr>
</table>

";
            // line 68
            if ((isset($context['Logged']) ? $context['Logged'] : null)) {
                echo "
    ";
                // line 69
                $this->env->loadTemplate("modules/Listingeng/UploadNewReport.html")->display($context);
                echo "
";
            }
            // line 70
            echo "

<script type=\"text/javascript\">

    \$(function() {
        \$(\"#hidden_balance\").dialog({
            autoOpen: false,
            height: 500,
            width: 500,
            modal: true,
            buttons: {           
                \"Закрыть\": function() {  
                    \$(this).dialog('close');
                }
            },
            close: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });
        \$(\"#hidden_prospect\").dialog({
            autoOpen: false,
            height: 500,
            width: 500,
            modal: true,
            buttons: {
                \"Закрыть\": function() {
                    \$(this).dialog('close');
                }
            },
            close: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });
        \$(\"#hidden_fin_rep\").dialog({
            autoOpen: false,
            height: 500,
            width: 500,
            modal: true,
            buttons: {
                \"Закрыть\": function() {
                    \$(this).dialog('close');
                }
            },
            close: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });
        \$(\"#hidden_cash_flow\").dialog({
            autoOpen: false,
            height: 500,
            width: 500,
            modal: true,
            buttons: {
                \"Закрыть\": function() {
                    \$(this).dialog('close');
                }
            },
            close: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });
        \$(\"#hidden_cap_rep\").dialog({
            autoOpen: false,
            height: 500,
            width: 500,
            modal: true,
            buttons: {
                \"Закрыть\": function() {
                    \$(this).dialog('close');
                }
            },
            close: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });
        \$(\"#hidden_news\").dialog({
            autoOpen: false,
            height: 500,
            width: 500,
            modal: true,
            buttons: {
                \"Закрыть\": function() {
                    \$(this).dialog('close');
                }
            },
            close: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });
        \$(\"#hidden_analytics\").dialog({
            autoOpen: false,
            height: 500,
            width: 500,
            modal: true,
            buttons: {
                \"Закрыть\": function() {
                    \$(this).dialog('close');
                }
            },
            close: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });

        \$('#showArchive_balance')
            .click(function() {
                \$('#hidden_balance').dialog('open');
            });
        \$('#showArchive_prospect')
            .click(function() {
                \$('#hidden_prospect').dialog('open');
            });
        \$('#showArchive_fin_rep')
            .click(function() {
                \$('#hidden_fin_rep').dialog('open');
            });
        \$('#showArchive_cash_flow')
            .click(function() {
                \$('#hidden_cash_flow').dialog('open');
            });
        \$('#showArchive_cap_rep')
            .click(function() {
                \$('#hidden_cap_rep').dialog('open');
            });
        \$('#showArchive_news')
            .click(function() {
                \$('#hidden_news').dialog('open');
            });
        \$('#showArchive_analytics')
            .click(function() {
                \$('#hidden_analytics').dialog('open');
            });
    });

    
</script>

<div style=\"float: right; width: 48%; margin-top: 20px;\">
    <h3>Information disclosing</h3>
    <table class=\"class1\" width=\"100%\">
    ";
            // line 210
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_iterator_to_array((isset($context['Reports']) ? $context['Reports'] : null));
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
            foreach ($context['_seq'] as $context['_key'] => $context['Report']) {
                echo "
    <tr>
        <td width=\"20px\"><a href=\"";
                // line 212
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/Listing/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">
                <img src=\"";
                // line 213
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/views/kse/images/icon_pdf.jpg\" width=\"20px\"/>
            </a></td>
        <td><a href=\"";
                // line 215
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/Listing/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Name", array(), "array");
                echo "</a></td>
        <td><a id=\"showArchive_";
                // line 216
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Type", array(), "array");
                echo "\">Archive</a></td>
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 218
            echo "
    </table>
</div>

<div id=\"hidden_balance\">
    <h3>Balance Sheet: Archive</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 225
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "balance", array(), "array"));
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
            foreach ($context['_seq'] as $context['_key'] => $context['Report']) {
                echo "
        <li style=\"height: 30px; border-bottom: 1px dashed #CCCCCC;\"><a href=\"";
                // line 226
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/Listing/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Date", array(), "any");
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 227
            echo "
    </ul>
</div>

<div id=\"hidden_prospect\">
    <h3>Listing prospect: Archive</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 234
            $context['_parent'] = (array) $context;
            $context['_iterated'] = false;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "prospect", array(), "array"));
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
            foreach ($context['_seq'] as $context['_key'] => $context['Report']) {
                $context['_iterated'] = true;
                echo "
        <li style=\"height: 30px; border-bottom: 1px dashed #CCCCCC;\"><a href=\"";
                // line 235
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/Listing/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Date", array(), "any");
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
            if (!$context['_iterated']) {
                // line 236
                echo "
        <li class=\"warning ui-corner-all\"><h3>No accessible files</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 238
            echo "
    </ul>
</div>

<div id=\"hidden_fin_rep\">
    <h3>Financial report: Archive</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 245
            $context['_parent'] = (array) $context;
            $context['_iterated'] = false;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "fin_rep", array(), "array"));
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
            foreach ($context['_seq'] as $context['_key'] => $context['Report']) {
                $context['_iterated'] = true;
                echo "
        <li style=\"height: 30px; border-bottom: 1px dashed #CCCCCC;\"><a href=\"";
                // line 246
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/Listing/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Date", array(), "any");
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
            if (!$context['_iterated']) {
                // line 247
                echo "
        <li class=\"warning ui-corner-all\"><h3>No accessible files</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 249
            echo "
    </ul>
</div>

<div id=\"hidden_cash_flow\">
    <h3>Cash flow: Archive</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 256
            $context['_parent'] = (array) $context;
            $context['_iterated'] = false;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "cash_flow", array(), "array"));
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
            foreach ($context['_seq'] as $context['_key'] => $context['Report']) {
                $context['_iterated'] = true;
                echo "
        <li style=\"height: 30px; border-bottom: 1px dashed #CCCCCC;\"><a href=\"";
                // line 257
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/Listing/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Date", array(), "any");
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
            if (!$context['_iterated']) {
                // line 258
                echo "
        <li class=\"warning ui-corner-all\"><h3>No accessible files</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 260
            echo "
    </ul>
</div>

<div id=\"hidden_cap_rep\">
    <h3>Capital report: Archive</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 267
            $context['_parent'] = (array) $context;
            $context['_iterated'] = false;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "cap_rep", array(), "array"));
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
            foreach ($context['_seq'] as $context['_key'] => $context['Report']) {
                $context['_iterated'] = true;
                echo "
        <li style=\"height: 30px; border-bottom: 1px dashed #CCCCCC;\"><a href=\"";
                // line 268
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/Listing/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Date", array(), "any");
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
            if (!$context['_iterated']) {
                // line 269
                echo "
        <li class=\"warning ui-corner-all\"><h3>No accessible files</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 271
            echo "
    </ul>
</div>

<div id=\"hidden_news\">
    <h3>News: Archive</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 278
            $context['_parent'] = (array) $context;
            $context['_iterated'] = false;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "news", array(), "array"));
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
            foreach ($context['_seq'] as $context['_key'] => $context['Report']) {
                $context['_iterated'] = true;
                echo "
        <li style=\"height: 30px; border-bottom: 1px dashed #CCCCCC;\"><a href=\"";
                // line 279
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/Listing/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Date", array(), "any");
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
            if (!$context['_iterated']) {
                // line 280
                echo "
        <li class=\"warning ui-corner-all\"><h3>No accessible files</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 282
            echo "
    </ul>
</div>

<div id=\"hidden_analytics\">
    <h3>Analytics: Archive</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 289
            $context['_parent'] = (array) $context;
            $context['_iterated'] = false;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "analytics", array(), "array"));
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
            foreach ($context['_seq'] as $context['_key'] => $context['Report']) {
                $context['_iterated'] = true;
                echo "
        <li style=\"height: 30px; border-bottom: 1px dashed #CCCCCC;\"><a href=\"";
                // line 290
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/Listing/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Date", array(), "any");
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
            if (!$context['_iterated']) {
                // line 291
                echo "
        <li class=\"warning ui-corner-all\"><h3>No accessible files</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 293
            echo "
    </ul>
</div>

";
        }
        // line 297
        echo "
";
        // line 298
        if ((isset($context['Logged']) ? $context['Logged'] : null)) {
            echo "
<div style=\"clear: both; width: 100%; padding: 15px; border: 1px solid #CCCCCC\" class=\"ui-corner-all\">
    <h2>Управление проспектом</h2>
    <br />
    <h3>Торговые символы</h3>
    <div class=\"notice ui-corner-all\">
        <h4>Рекомендация</h4>
        <p>Каждый символ распологается на новой строке. 
            Первым торговым символом должен идти официальный торговый символ</p>
    </div>
    <form action=\"";
            // line 308
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/modules/Listing/Symbols.php\" method=\"POST\">
    <textarea name=\"SymbolsList\" style=\"border: 1px solid #CCCCCC;\" rows=\"";
            // line 309
            echo (isset($context['SymbolsNum']) ? $context['SymbolsNum'] : null);
            echo "\">";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_iterator_to_array((isset($context['SymbolsList']) ? $context['SymbolsList'] : null));
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
            foreach ($context['_seq'] as $context['_key'] => $context['Symbol']) {
                echo (isset($context['Symbol']) ? $context['Symbol'] : null);
                echo "\\n";
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Symbol'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            echo "</textarea>
    <br />
    <input type=\"submit\" name=\"doUpdateSymbols\" value=\"Обновить символы\" />
    <input type=\"hidden\" name=\"CompanyId\" value=\"";
            // line 312
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "CompanyId", array(), "array");
            echo "\" />
    <input type=\"hidden\" name=\"url\" value=\"";
            // line 313
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/";
            echo (isset($context['lang_code']) ? $context['lang_code'] : null);
            echo "/Listing\" />
    </form>
</div>
";
        }
        // line 316
        echo "

";
    }

}
