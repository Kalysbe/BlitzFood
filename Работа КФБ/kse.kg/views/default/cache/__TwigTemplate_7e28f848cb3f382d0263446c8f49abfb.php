<?php

/* modules/BuySellOrders/BuySellOrders.html */
class __TwigTemplate_7e28f848cb3f382d0263446c8f49abfb extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<?php session_start();?>


<SCRIPT type=\"text/javascript\">
function validate_form ( )
{
\tvalid = true;

        if ( document.buysell.mEmitent.value == \"\" )
        {
                alert ( \"Пожалуйста заполните поле 'Ценная бумага'.\" );
                valid = false;
        }
\t\telse
\t\tif ( document.buysell.mPrice.value == \"\" )
        {
                alert ( \"Пожалуйста заполните поле 'Цена'.\" );
                valid = false;
        }
\t\telse
\t\tif ( document.buysell.mAmount.value == \"\" )
        {
                alert ( \"Пожалуйста заполните поле 'Количество'.\" );
                valid = false;
        }
\t\telse
\t\tif ( document.buysell.mText.value == \"\" )
        {
                alert ( \"Пожалуйста заполните поле 'Комментарии'.\" );
                valid = false;
        }
\t\telse
\t\tif ( (document.buysell.turing.value == \"\") || (document.buysell.turing === \"undefined\"))
        {
                alert ( \"Пожалуйста введите 'Код на картинке'.\" );
                valid = false;
        }
\t\treturn valid;
}

</SCRIPT>


<h2>";
        // line 44
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "kuplyaprodazha", array(), "array");
        echo "</h2>
<br /><br/>

";
        // line 47
        if ((isset($context['SendResult']) ? $context['SendResult'] : null)) {
            echo "
<div class=\"error ui-corner-all\">
    ";
            // line 49
            echo (isset($context['SendResult']) ? $context['SendResult'] : null);
            echo "
</div><br /><br />
";
        }
        // line 51
        echo "

";
        // line 53
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "byesell", array(), "array");
        echo "
<br />

<br>

<form name=\"buysell\" action=\"\" method=\"POST\" onsubmit=\"return validate_form();\">
    ";
        // line 59
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "operaciya", array(), "array");
        echo "
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name=\"mOperation\">
        <option value=\"Продажа\">";
        // line 61
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "prodazha", array(), "array");
        echo "</option>
        <option value=\"Покупка\">";
        // line 62
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "pokupka", array(), "array");
        echo "</option>
    </select><br /><br />
    ";
        // line 64
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "bumaga", array(), "array");
        echo " <input type=\"text\" name=\"mEmitent\" value=\"\" /><br /><br />
    ";
        // line 65
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "cena", array(), "array");
        echo "  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" name=\"mPrice\" value=\"\" /><br /><br />
    ";
        // line 66
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "kolvo", array(), "array");
        echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" name=\"mAmount\" value=\"\" /><br /><br />
    ";
        // line 67
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "comment", array(), "array");
        echo " <textarea name=\"mText\" style=\"width: 100%; height: 150px; border: 1px solid #CCCCCC;\"></textarea><br /><br />
    ";
        // line 68
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "cod", array(), "array");
        echo "  <img src=\"";
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/templates/modules/BuySellOrders/turing\"/>
\t
\t<input type=\"text\" name=\"turing\" size=\"4\"><br><br>
\t<input type=\"submit\" name=\"doSendMessage\" value=\"Отправить\" class=\"button\" />
    <br />
    <br />
</form>

";
    }

}
