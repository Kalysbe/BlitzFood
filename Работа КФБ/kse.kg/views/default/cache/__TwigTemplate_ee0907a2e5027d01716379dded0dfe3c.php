<?php

/* modules/Listing/UploadNewReport.html */
class __TwigTemplate_ee0907a2e5027d01716379dded0dfe3c extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "
<div style=\"float: right; width: 45%; border: 1px solid #CCCCCC; padding: 5px;\" class=\"ui-corner-all\">
    <form action=\"";
        // line 3
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/modules/Listing/UploadReport.php\" method=\"POST\" enctype=\"multipart/form-data\">
    <input type=\"hidden\" name=\"CompanyId\" value=\"";
        // line 4
        echo $this->getAttribute((isset($context['CompanyInfo']) ? $context['CompanyInfo'] : null), "CompanyId", array(), "array");
        echo "\" />
    <h3>Загрузить новый отчет</h3>
    <label>
        Тип отчета:
    </label>
    <select name=\"report_type\">
        <option value=\"balance\">Баланс</option>
        <option value=\"prospect\">Проспект</option>
        <option value=\"fin_rep\">Отчет о финансовых результатах</option>
        <option value=\"cash_flow\">Отчет о движении денежных средств</option>
        <option value=\"cap_rep\">Отчет об изменениях в капитале</option>
        <option value=\"news\">Новости</option>
        <option value=\"analytics\">Соблюдение нормативов</option>
\t\t<option value=\"corporate\">Кодекс корпоративного управления</option>
\t\t<option value=\"auditreport\">Аудиторское заключение</option>
\t\t<option value=\"historyreport\">История компании</option>
    </select>
    <br />
    <label>Файл:</label><p><input type=\"file\" name=\"report_file\" /></p>
    <label>Дата отчета:</label>
    <p><input type=\"textarea\" name=\"report_date\" value=\"\" id=\"report_date\" style=\"border: 1px solid #CCCCCC;\"/></p>
    <script type=\"text/javascript\">
        \$(\"#report_date\").datepicker({ dateFormat: 'yy-mm-dd' });
    </script><br />
    <center><input type=\"submit\" name=\"do_upload_report\" value=\"Загрузить\" /></center><br /><br />
    </form>
</div>
<br /><br />";
    }

}
