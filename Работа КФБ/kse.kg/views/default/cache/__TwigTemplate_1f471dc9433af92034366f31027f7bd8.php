<?php

/* modules/Listing/Details.html */
class __TwigTemplate_1f471dc9433af92034366f31027f7bd8 extends Twig_Template
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
        <th>Общая информация</th>
        <th>&nbsp;</th>
    </tr>
    <tr>
        <td>Наименование компании</td>
        <td>";
            // line 16
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "CompanyName", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Ценная бумага</td>
        <td>";
            // line 20
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Security", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Торговые символы</td>
        <td>";
            // line 24
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Symbols", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Отрасль</td>
        <td>";
            // line 28
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Sphere", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Вид деятельности</td>
        <td>";
            // line 32
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Activity", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Дата прохождения листинга </td>
        <td>";
            // line 36
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "ListingDate", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>ФИО руководителя</td>
        <td>";
            // line 40
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Owner", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Должность руководителя </td>
        <td>";
            // line 44
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "OwnerPosition", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Адрес</td>
        <td>";
            // line 48
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Address", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Телефон / Факс </td>
        <td>";
            // line 52
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Phone", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Аудитор </td>
        <td>";
            // line 56
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Auditor", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Регистратор </td>
        <td>";
            // line 60
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "Registrar", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Маркет-мейкер </td>
        <td>";
            // line 64
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "MarketMaker", array(), "array");
            echo "</td>
    </tr>
</table>


";
            // line 69
            if (((isset($context['Logged']) ? $context['Logged'] : null)) && ($this->getAttribute((isset($context['LoggedUser']) ? $context['LoggedUser'] : null), "getUsername", array(), "any") == "admin")) {
                echo "
    ";
                // line 70
                $this->env->loadTemplate("modules/Listing/UploadNewReport.html")->display($context);
                echo "
";
            }
            // line 71
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
\t\t \$(\"#hidden_corporate\").dialog({
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
\t\t \$(\"#hidden_auditreport\").dialog({
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
\t\t \$(\"#hidden_historyreport\").dialog({
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
\t\t\$('#showArchive_corporate')
            .click(function() {
                \$('#hidden_corporate').dialog('open');
            });
\t\t\$('#showArchive_auditreport')
            .click(function() {
                \$('#hidden_auditreport').dialog('open');
            });
\t\t\$('#showArchive_historyreport')
            .click(function() {
                \$('#hidden_historyreport').dialog('open');
            });
    });

    
</script>

<div style=\"float: right; width: 48%; margin-top: 20px;\">
    <h3>Раскрытие информации</h3>
    <table class=\"class1\" width=\"100%\">
    ";
            // line 265
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
                // line 267
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/Listing/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">
                <img src=\"";
                // line 268
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/views/kse/images/icon_pdf.jpg\" width=\"20px\"/>
            </a></td>
        <td><a href=\"";
                // line 270
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/Listing/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Name", array(), "array");
                echo "</a></td>
        <td><a id=\"showArchive_";
                // line 271
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Type", array(), "array");
                echo "\">Архив</a></td>
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
            // line 273
            echo "
    </table>

    ";
            // line 276
            if ($this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "note", array(), "array") != "") {
                echo "
        <div class=\"note\">
            <h3>Примечание</h3>
            <p>
                ";
                // line 280
                echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "note", array(), "array");
                echo "
            </p>
        </div>
    ";
            }
            // line 283
            echo "
</div>

<div id=\"hidden_balance\">
    <h3>Бухгалтерский Баланс: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 289
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
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 291
            echo "
    </ul>
</div>

<div id=\"hidden_prospect\">
    <h3>Листинговый проспект: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 298
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
                // line 299
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
                // line 300
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 302
            echo "
    </ul>
</div>

<div id=\"hidden_fin_rep\">
    <h3>Отчет о финансовых результатах: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 309
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
                // line 310
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
                // line 311
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 313
            echo "
    </ul>
</div>

<div id=\"hidden_cash_flow\">
    <h3>Отчет о движении денежных средств: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 320
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
                // line 321
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
                // line 322
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 324
            echo "
    </ul>
</div>

<div id=\"hidden_cap_rep\">
    <h3>Отчет об изменениях в капитале: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 331
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
                // line 332
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
                // line 333
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 335
            echo "
    </ul>
</div>

<div id=\"hidden_news\">
    <h3>Новости: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 342
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
                // line 343
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
                // line 344
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 346
            echo "
    </ul>
</div>

<div id=\"hidden_analytics\">
    <h3>Соблюдение нормативов: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 353
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
                // line 354
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
                // line 355
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 357
            echo "
    </ul>
</div>

<div id=\"hidden_corporate\">
    <h3>Кодекс корпоративного управления: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 364
            $context['_parent'] = (array) $context;
            $context['_iterated'] = false;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "corporate", array(), "array"));
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
                // line 365
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
                // line 366
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 368
            echo "
    </ul>
</div>

<div id=\"hidden_auditreport\">
    <h3>Аудиторское заключение: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 375
            $context['_parent'] = (array) $context;
            $context['_iterated'] = false;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "auditreport", array(), "array"));
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
                // line 376
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
                // line 377
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 379
            echo "
    </ul>
</div>

<div id=\"hidden_historyreport\">
    <h3>История компании: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 386
            $context['_parent'] = (array) $context;
            $context['_iterated'] = false;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "historyreport", array(), "array"));
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
                // line 387
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
                // line 388
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 390
            echo "
    </ul>
</div>



";
        }
        // line 396
        echo "


";
        // line 399
        if (((isset($context['Logged']) ? $context['Logged'] : null)) && ($this->getAttribute((isset($context['LoggedUser']) ? $context['LoggedUser'] : null), "getUsername", array(), "any") == "admin")) {
            echo "
<div style=\"clear: both; width: 100%; padding: 15px; border: 1px solid #CCCCCC\" class=\"ui-corner-all\">
    <h2>Примечание</h2>
    <br />
    <form action=\"";
            // line 403
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/modules/Listing/UploadDetails.php\" method=\"POST\">
        <textarea name=\"note\" style=\"border: 1px solid #CCCCCC;\" cols=\"100\" rows=\"15\">";
            // line 404
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "note", array(), "array");
            echo "</textarea>
        <input type=\"hidden\" name=\"CompanyId\" value=\"";
            // line 405
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "CompanyId", array(), "array");
            echo "\" />
        <br />
        <input type=\"submit\" name=\"doUpdateNote\" value=\"Обновить примечание\" />
    </form>
</div>
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
            // line 419
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/modules/Listing/Symbols.php\" method=\"POST\">
    <textarea name=\"SymbolsList\" style=\"border: 1px solid #CCCCCC;\" rows=\"";
            // line 420
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
            // line 423
            echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "CompanyId", array(), "array");
            echo "\" />
    <input type=\"hidden\" name=\"url\" value=\"";
            // line 424
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/";
            echo (isset($context['lang_code']) ? $context['lang_code'] : null);
            echo "/Listing\" />
    </form>
</div>
";
        }
        // line 427
        echo "

";
    }

}
