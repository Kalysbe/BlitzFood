<?php

/* modules/BusinessReports/Details.html */
class __TwigTemplate_17e4cba154e717fa928ec47daef3b5d8 extends Twig_Template
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

<h2>";
            // line 9
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "title", array(), "array");
            echo "</h2>

<table class=\"class1\" width=\"45%\" style=\"float: left;\">
    <tr>
        <th>Общая информация</th>
        <th>&nbsp;</th>
    </tr>
    <tr>
        <td>Наименование компании</td>
        <td>";
            // line 18
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "title", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Вид деятельности</td>
        <td>";
            // line 22
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "activity", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>ФИО руководителя</td>
        <td>";
            // line 26
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "owner", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Должность руководителя </td>
        <td>";
            // line 30
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "owner_position", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Адрес</td>
        <td>";
            // line 34
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "address", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Телефон / Факс </td>
        <td>";
            // line 38
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "phone", array(), "array");
            echo "</td>
    </tr>
    <tr>
        <td>Регистратор </td>
        <td>";
            // line 42
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "registrar", array(), "array");
            echo "</td>
    </tr>
\t <tr>
        <td>Вид ценных бумаг </td>
        <td>";
            // line 46
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "t_securities", array(), "array");
            echo "</td>
    </tr>
\t <tr>
        <td>Количество ценных бумаг </td>
        <td>";
            // line 50
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "n_securities", array(), "array");
            echo "</td>
    </tr>
\t <tr>
        <td>Цена размещения </td>
        <td>";
            // line 54
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "f_price", array(), "array");
            echo "</td>
    </tr>
</table>

";
            // line 58
            if (((isset($context['Logged']) ? $context['Logged'] : null)) && ($this->getAttribute((isset($context['LoggedUser']) ? $context['LoggedUser'] : null), "getUsername", array(), "any") == "admin")) {
                echo "
    ";
                // line 59
                $this->env->loadTemplate("modules/BusinessReports/UploadNewReport.html")->display($context);
                echo "
";
            }
            // line 60
            echo "

<script type=\"text/javascript\">

    \$(function() {

        \$(\"#hidden_bulletin\").dialog({
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
        \$(\"#hidden_quarterly\").dialog({
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
        \$(\"#hidden_annual\").dialog({
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

        \$('#showArchive_bulletin')
            .click(function() {
                \$('#hidden_bulletin').dialog('open');
            });
        \$('#showArchive_quarterly')
            .click(function() {
                \$('#hidden_quarterly').dialog('open');
            });
        \$('#showArchive_annual')
            .click(function() {
                \$('#hidden_annual').dialog('open');
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
    <h3>Раскрытие информации</h3>
    <table class=\"class1\" width=\"100%\">
    ";
            // line 163
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
                // line 165
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/files/BusinessReports/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">
                <img src=\"";
                // line 166
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/views/kse/images/icon_pdf.jpg\" width=\"20px\"/>
            </a></td>
        <td><a href=\"";
                // line 168
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/files/BusinessReports/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Name", array(), "array");
                echo "</a></td>
        <td><a id=\"showArchive_";
                // line 169
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
            // line 171
            echo "
    </table>
</div>

<div style=\"float: right; width: 48%; margin-top: 20px;\">
    <h3>Новости компании</h3>
    <table class=\"class1\" width=\"100%\">
\t";
            // line 178
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_iterator_to_array((isset($context['NewsList']) ? $context['NewsList'] : null));
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
            foreach ($context['_seq'] as $context['_key'] => $context['news']) {
                echo "
    <tr>
        <td ><strong>";
                // line 180
                echo $this->getAttribute((isset($context['news']) ? $context['news'] : null), "news_date", array(), "any");
                echo "</strong> <a href=\"";
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/";
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "/";
                echo (isset($context['blogName']) ? $context['blogName'] : null);
                echo "/";
                echo $this->getAttribute((isset($context['news']) ? $context['news'] : null), "news_id", array(), "array");
                echo "/";
                echo $this->getAttribute((isset($context['news']) ? $context['news'] : null), "news_title", array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['news']) ? $context['news'] : null), "news_title", array(), "array");
                echo "</a></td>
    </tr>\t
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['news'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 182
            echo "
    </table>
</div>

<div id=\"hidden_bulletin\">
    <h3>Бюллетень эмитента: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 189
            $context['_parent'] = (array) $context;
            $context['_iterated'] = false;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "bulletin", array(), "array"));
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
                // line 190
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/files/BusinessReports/";
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
                // line 191
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 193
            echo "
    </ul>
</div>

<div id=\"hidden_quarterly\">
    <h3>Ежевартальный отчёт: Архив</h3><br />
\t<!-- <li class=\"warning ui-corner-all\"><h3>Для доступа к файлам, напишите на почту irina@kse.kg</h3></li> -->
    <ul class=\"leftmenu\">
    ";
            // line 201
            $context['_parent'] = (array) $context;
            $context['_iterated'] = false;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "quarterly", array(), "array"));
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
\t<h3>";
                // line 202
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "kvdate", array(), "any");
                echo "</h3>
        <li style=\"height: 30px; border-bottom: 1px dashed #CCCCCC;\">
        \t<a href=\"";
                // line 204
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/files/BusinessReports/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">
        \t Дата размещения: ";
                // line 205
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Date", array(), "any");
                echo "
        \t</a>
        \t";
                // line 207
                if (((isset($context['Logged']) ? $context['Logged'] : null)) && ($this->getAttribute((isset($context['LoggedUser']) ? $context['LoggedUser'] : null), "getUsername", array(), "any") == "admin")) {
                    echo "
        \t\t<a href=\"?test=";
                    // line 208
                    echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "brep_report_id", array(), "array");
                    echo "\">Удалить</a>
        \t";
                }
                // line 209
                echo "
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
            if (!$context['_iterated']) {
                // line 211
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 213
            echo "
    </ul>
</div>

<div id=\"hidden_annual\">
    <h3>Годовой отчёт: Архив</h3><br /><br />
\t<!-- <li class=\"warning ui-corner-all\"><h3>Для доступа к файлам, напишите на почту irina@kse.kg</h3></li> -->
    <ul class=\"leftmenu\">
    ";
            // line 221
            $context['_parent'] = (array) $context;
            $context['_iterated'] = false;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute((isset($context['ReportsArchive']) ? $context['ReportsArchive'] : null), "annual", array(), "array"));
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
    
        <h3> ";
                // line 223
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "kvartal", array(), "any");
                echo " </h3>
           
        <li style=\"height: 30px; border-bottom: 1px dashed #CCCCCC;\">
        \t<a href=\"";
                // line 226
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/files/BusinessReports/";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Filepath", array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "Date", array(), "any");
                echo "</a>
        \t";
                // line 227
                if (((isset($context['Logged']) ? $context['Logged'] : null)) && ($this->getAttribute((isset($context['LoggedUser']) ? $context['LoggedUser'] : null), "getUsername", array(), "any") == "admin")) {
                    echo "
        \t\t<a href=\"?test=";
                    // line 228
                    echo $this->getAttribute((isset($context['Report']) ? $context['Report'] : null), "brep_report_id", array(), "array");
                    echo "\">Удалить</a>
        \t";
                }
                // line 229
                echo "
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
            if (!$context['_iterated']) {
                // line 231
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 233
            echo "
    </ul>
</div>

<div id=\"hidden_news\">
    <h3>Новости: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 240
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
                // line 241
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/files/BusinessReports/";
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
                // line 242
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 244
            echo "
    </ul>
</div>

<div id=\"hidden_analytics\">
    <h3>Аналитика: Архив</h3><br /><br />
    <ul class=\"leftmenu\">
    ";
            // line 251
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
                // line 252
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/files/BusinessReports/";
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
                // line 253
                echo "
        <li class=\"warning ui-corner-all\"><h3>Нет доступных файлов</h3></li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Report'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 255
            echo "
    </ul>
</div>

";
        }
        // line 259
        echo "
";
        // line 260
        if (((isset($context['Logged']) ? $context['Logged'] : null)) && ($this->getAttribute((isset($context['LoggedUser']) ? $context['LoggedUser'] : null), "getUsername", array(), "any") == "admin")) {
            echo "
<div style=\"clear: both; width: 100%; padding: 15px; border: 1px solid #CCCCCC\" class=\"ui-corner-all\">
    <h2>Управление проспектом</h2>
    <br />
    <form action=\"\" method=\"POST\">
        <table class=\"class1\" >
            <tr>
                <th>Поле</th>
                <th>Значение</th>
            </tr>
            <tr>
                <td>Адрес странички (латиница)</td>
                <td><input type=\"text\" name=\"brep_company_name\" value=\"";
            // line 272
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "name", array(), "array");
            echo "\" /></td>
            </tr>
            <tr>
                <td>Наименование компании</td>
                <td><input type=\"text\" name=\"title\" value=\"";
            // line 276
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "title", array(), "array");
            echo "\" /></td>
            </tr>
            <tr>
                <td>Вид деятельности</td>
                <td><input type=\"text\" name=\"activity\" value=\"";
            // line 280
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "activity", array(), "array");
            echo "\" /></td>
            </tr>
            <tr>
                <td>ФИО руководителя</td>
                <td><input type=\"text\" name=\"owner\" value=\"";
            // line 284
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "owner", array(), "array");
            echo "\" /></td>
            </tr>
            <tr>
                <td>Должность руководителя </td>
                <td><input type=\"text\" name=\"owner_position\" value=\"";
            // line 288
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "owner_position", array(), "array");
            echo "\" /></td>
            </tr>
            <tr>
                <td>Адрес</td>
                <td><input type=\"text\" name=\"address\" value=\"";
            // line 292
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "address", array(), "array");
            echo "\" /></td>
            </tr>
            <tr>
                <td>Телефон / Факс </td>
                <td><input type=\"text\" name=\"phone\" value=\"";
            // line 296
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "phone", array(), "array");
            echo "\" /></td>
            </tr>
            <tr>
                <td>Регистратор </td>
                <td><input type=\"text\" name=\"registrar\" value=\"";
            // line 300
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "registrar", array(), "array");
            echo "\" /></td>
            </tr>
\t\t\t  <tr>
                <td>Вид ценных бумаг </td>
                <td><input type=\"text\" name=\"t_securities\" value=\"";
            // line 304
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "t_securities", array(), "array");
            echo "\" /></td>
            </tr>
\t\t\t  <tr>
                <td>Количество ценных бумаг </td>
                <td><input type=\"text\" name=\"n_securities\" value=\"";
            // line 308
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "n_securities", array(), "array");
            echo "\" /></td>
            </tr>
\t\t\t  <tr>
                <td>Цена размещения </td>
                <td><input type=\"text\" name=\"f_price\" value=\"";
            // line 312
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "f_price", array(), "array");
            echo "\" /></td>
            </tr>
        </table>
        <input type=\"hidden\" name=\"brep_company_id\" value=\"";
            // line 315
            echo $this->getAttribute((isset($context['company_info']) ? $context['company_info'] : null), "id", array(), "array");
            echo "\" />
        <input type=\"submit\" name=\"doUpdateCompany\" value=\"Сохранить\" />
    </form>
</div>
";
        }
        // line 319
        echo "
<!-- 
";
        // line 321
        if ((isset($context['Logged']) ? $context['Logged'] : null) == false) {
            echo "
<script type=\"text/javascript\">
    \$(\".leftmenu li a\").removeAttr(\"href\")
</script>
";
        }
        // line 325
        echo " -->

";
    }

}
