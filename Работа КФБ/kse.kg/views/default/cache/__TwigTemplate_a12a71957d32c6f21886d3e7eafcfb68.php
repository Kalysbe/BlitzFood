<?php

/* register_page.html */
class __TwigTemplate_a12a71957d32c6f21886d3e7eafcfb68 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<div id=\"two_columns\">
    <form action=\"";
        // line 2
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/handlers/register.php\" method=\"POST\">
        <label>Имя для входа (Логин):</label>
        <p><input type=\"text\" name=\"mLogin\" value=\"\" id=\"mfLogin\" class=\"text ui-widget-content ui-corner-all\" /></p>
        <label>Пароль:</label>
        <p><input type=\"password\" name=\"mPass\" value=\"\" id=\"mfPass\" class=\"text ui-widget-content ui-corner-all\" /></p>
        <label>Подтверждение пароля:</label>
        <p><input type=\"password\" name=\"mPassConfirm\" value=\"\" id=\"mfPass\" class=\"text ui-widget-content ui-corner-all\" /></p>
        <label>Электронный адрес:</label>
        <p><input type=\"text\" name=\"mEmail\" value=\"\" id=\"mfPass\" class=\"text ui-widget-content ui-corner-all\" /></p>
        <label>&nbsp;</label>
        <p><input type=\"submit\" name=\"doRegister\" value=\"";
        // line 12
        echo $this->getAttribute((isset($context['Lang']) ? $context['Lang'] : null), "{doRegister}", array(), "array");
        echo "\" /></p>
    </form>
</div>";
    }

}
