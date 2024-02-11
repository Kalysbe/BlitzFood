<?php

/* login_page.html */
class __TwigTemplate_c7ac9d0a833096847cd132c87189356d extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<div id=\"two_columns\">
    <form action=\"";
        // line 2
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/handlers/login.php\" method=\"POST\">
        <label>Логин:</label>
        <p><input type=\"text\" name=\"mfLogin\" value=\"\" id=\"mfLogin\" class=\"text ui-widget-content ui-corner-all\" /></p>
        <label>Пароль:</label>
        <p><input type=\"password\" name=\"mfPass\" value=\"\" id=\"mfPass\" class=\"text ui-widget-content ui-corner-all\" /></p>
        <label>&nbsp;</label>
        <p><input type=\"submit\" name=\"doLogin\" value=\"";
        // line 8
        echo $this->getAttribute((isset($context['Lang']) ? $context['Lang'] : null), "{doLogIn}", array(), "array");
        echo "\" /></p>
    </form>
</div>";
    }

}
