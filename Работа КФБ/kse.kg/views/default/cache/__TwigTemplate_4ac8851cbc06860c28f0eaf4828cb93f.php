<?php

/* page_rename.html */
class __TwigTemplate_4ac8851cbc06860c28f0eaf4828cb93f extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<div>
    <div class=\"warning ui-corner-all\">
    <h3>Вы действительно хотите переименовать страницу?</h3>
    <p>Страница <a href=\"";
        // line 4
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/";
        echo $this->getAttribute((isset($context['SubPage']) ? $context['SubPage'] : null), "Uname", array(), "any");
        echo "\">";
        echo $this->getAttribute((isset($context['SubPage']) ? $context['SubPage'] : null), "Uname", array(), "any");
        echo "</a> больше не будет доступна, пока Вы не
    создадите страницу с таким-же именем. Содержимое и заголвок страницы останутся без изменений. Также,
    обратите внимание на то, что Вам необходимо вручную изменить ссылки на с других страниц на новый адрес.
    В противном случае, пользователи не будут получать страницу со старым именем перейдя по ссылке. </p>
    </div>
    <form action=\"";
        // line 9
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/handlers/renamepage.php\" method=\"POST\">
        <div id=\"two_columns\">
            <label>Старое имя:</label>
            <p><strong>";
        // line 12
        echo $this->getAttribute((isset($context['SubPage']) ? $context['SubPage'] : null), "Uname", array(), "any");
        echo "</strong></p>
            <div class=\"clean\"></div>
            <label>Новое имя:</label>
            <p><input type=\"text\" name=\"mNewPageName\" value=\"\" class=\"ui-widget-content ui-corner-all\" /></p>
            <div class=\"clean\"></div>
            <label>&nbsp;</label>
            <p><input type=\"submit\" name=\"doRenamePage\" value=\"Переименовать\" /></p>
            <input type=\"hidden\" name=\"pageId\" value=\"";
        // line 19
        echo $this->getAttribute((isset($context['SubPage']) ? $context['SubPage'] : null), "Id", array(), "any");
        echo "\" />
            <div class=\"clean\"></div>
        </div>
    </form>
</div>
";
    }

}
