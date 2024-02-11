<?php

/* new_page.html */
class __TwigTemplate_c993a98148c09b1444bf20dfddd25df3 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<div id=\"two_columns\">
    <form action=\"";
        // line 2
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/handlers/newpage.php\" method=\"POST\" enctype=\"multipart/form-data\">
        <label>Системное имя страницы:</label>
        <p><input type=\"text\" name=\"mPageName\" value=\"";
        // line 4
        echo (isset($context['SubPageUri']) ? $context['SubPageUri'] : null);
        echo "\" class=\"ui-widget-content ui-corner-all\" /></p>
        <div class=\"clean\"></div>
        <label>Наименование страницы:</label>
        <p><input type=\"text\" name=\"mPageTitle\" value=\"\" class=\"ui-widget-content ui-corner-all\" /></p>
        <div class=\"clean\"></div>
        <label>Категория:</label>
        <p><input type=\"text\" name=\"mPageNamespace\" value=\"\" class=\"ui-widget-content ui-corner-all\" /></p>
        <div class=\"clean\"></div>
        <label>Все категории:</label>
        <p>
            ";
        // line 14
        $context['_parent'] = (array) $context;
        $context['_iterated'] = false;
        $context['_seq'] = twig_iterator_to_array((isset($context['Categories']) ? $context['Categories'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['Category']) {
            $context['_iterated'] = true;
            echo "
                ";
            // line 15
            echo (isset($context['Category']) ? $context['Category'] : null);
            echo "
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
            // line 16
            echo "
            <strong>Категорий нет</strong>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Category'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 18
        echo "
        </p>
        <div class=\"clean\"></div>
        <label>Текст:</label>
        <p style=\"clear: both;\">
            <textarea id=\"mPageText\" name=\"mPageText\"></textarea>
        </p>
        <div class=\"clean\"></div>
        <label>&nbsp;</label>
        <p><input type=\"submit\" name=\"doAddPage\" value=\"Сохранить\" /></p>
        <div class=\"clean\"></div>
        ";
        // line 29
        $this->env->loadTemplate("attachment.html")->display($context);
        echo "
    </form>
</div>

<script type=\"text/javascript\">
    \$(document).ready(function() {
        \$(\"#mPageText\").ckeditor({language: 'ru'});
    });
</script>";
    }

}
