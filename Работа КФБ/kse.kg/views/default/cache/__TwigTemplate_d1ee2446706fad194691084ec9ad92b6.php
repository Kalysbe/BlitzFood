<?php

/* modules/Pages/EditPage.html */
class __TwigTemplate_d1ee2446706fad194691084ec9ad92b6 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        if ((isset($context['AdminRights']) ? $context['AdminRights'] : null)) {
            echo "
<h2>Редактирование страницы</h2>

";
            // line 4
            if ((isset($context['PageSaved']) ? $context['PageSaved'] : null)) {
                echo "

<div class=\"warning ui-corner-all\">
    Страница была успешно сохранена.
    <a href=\"";
                // line 8
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/";
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "/";
                echo $this->getAttribute((isset($context['EditPage']) ? $context['EditPage'] : null), "page_uname", array(), "array");
                echo "\">Перейти: ";
                echo $this->getAttribute((isset($context['EditPage']) ? $context['EditPage'] : null), "page_title", array(), "array");
                echo "</a>
</div>
";
            }
            // line 10
            echo "

<div id=\"two_columns\">
    <form action=\"\" method=\"POST\">
        <label>Системное имя страницы:</label>
        <p>";
            // line 15
            echo $this->getAttribute((isset($context['EditPage']) ? $context['EditPage'] : null), "page_uname", array(), "array");
            echo "</p>
        <div class=\"clean\"></div>
        <label>Наименование страницы:</label>
        <p><input type=\"text\" name=\"mPageTitle\" value=\"";
            // line 18
            echo $this->getAttribute((isset($context['EditPage']) ? $context['EditPage'] : null), "page_title", array(), "array");
            echo "\" class=\"ui-widget-content ui-corner-all\" /></p>
        <div class=\"clean\"></div>
        <label>Текст:</label>
        <p style=\"clear: both;\">
            <textarea id=\"mPageText\" name=\"mPageText\" style=\"width: 100%; height: 300px; border: 1px solid #CCCCCC\">";
            // line 22
            echo $this->getAttribute((isset($context['EditPage']) ? $context['EditPage'] : null), "page_text", array(), "array");
            echo "</textarea>
\t\t<script type=\"text/javascript\">
\t\t\tCKEDITOR.replace( \"mPageText\" );
\t\t</script>
        </p>
        <div class=\"clean\"></div>
        <label>&nbsp;</label>
        <p><input type=\"submit\" name=\"doEditPage\" value=\"Сохранить\" /></p>
        <div class=\"clean\"></div>
        <input type=\"hidden\" name=\"page_id\" value=\"";
            // line 31
            echo $this->getAttribute((isset($context['EditPage']) ? $context['EditPage'] : null), "page_id", array(), "array");
            echo "\" />
        <input type=\"hidden\" name=\"page_uname\" value=\"";
            // line 32
            echo $this->getAttribute((isset($context['EditPage']) ? $context['EditPage'] : null), "page_uname", array(), "array");
            echo "\" />
        <input type=\"button\" id=\"attachments_button\" name=\"attachments_button\" value=\"Прикрепить документ\" />
        <br /><br />
        <h3>Прикреплённые документы:</h3>
        <br />
        <ul>
        ";
            // line 38
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_iterator_to_array((isset($context['attachments_list']) ? $context['attachments_list'] : null));
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
            foreach ($context['_seq'] as $context['_key'] => $context['Att']) {
                echo "
            <li><h4>";
                // line 39
                echo $this->getAttribute((isset($context['Att']) ? $context['Att'] : null), "name", array(), "array");
                echo "</h4>
                <a href=\"#\" onClick=\"deattachFile(";
                // line 40
                echo $this->getAttribute((isset($context['Att']) ? $context['Att'] : null), "attachment_id", array(), "array");
                echo ")\" id=\"deattach_link_";
                echo $this->getAttribute((isset($context['Att']) ? $context['Att'] : null), "attachment_id", array(), "array");
                echo "\">Удалить</a>
                <br />
                <strong>Ссылки:</strong>
                <ul>
                    <li>Полная: ";
                // line 44
                echo (isset($context['root']) ? $context['root'] : null);
                echo $this->getAttribute((isset($context['Att']) ? $context['Att'] : null), "filepath", array(), "array");
                echo $this->getAttribute((isset($context['Att']) ? $context['Att'] : null), "filename", array(), "array");
                echo "</li>
                    <li>Относительная:";
                // line 45
                echo $this->getAttribute((isset($context['Att']) ? $context['Att'] : null), "filepath", array(), "array");
                echo $this->getAttribute((isset($context['Att']) ? $context['Att'] : null), "filename", array(), "array");
                echo "</li>
                </ul>
                
                
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
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Att'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 50
            echo "
        </ul>
        <div id=\"attachments_list\" style=\"display: none;\">
        </div>
        <div id=\"deattachments_list\" style=\"display: none;\">
        </div>
    </form>
</div>

<script type=\"text/javascript\">
    \$(document).ready(function() {
        \$(\"#mPageText\").ckeditor({language: 'ru'});
        \$(\"#attachments_button\").button();
    });

    function attachFile(id) {
        \$(\"#attachments_list\").append('<input type=\"hidden\" name=\"attachment' + id +'\" value=' +  id +' />');
        \$(\"#attach_link_\" + id).css(\"display\", \"none\");
    }

    function deattachFile(id) {
        \$(\"#deattachments_list\").append('<input type=\"hidden\" name=\"deattachment' + id +'\" value=' +  id +' />');
        \$(\"#deattach_link_\" + id).css(\"display\", \"none\");
    }
</script>
";
        } else {
            // line 75
            echo "
<div class=\"error ui-corner-all\">
    У Вас нет доступа к содержимому этой страницы
</div>
";
        }
        // line 79
        echo "

<br /><br />
<div id=\"file_list\">
    <h3>Доступные файлы:</h3>
    <ul>
    ";
        // line 85
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['file_list']) ? $context['file_list'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['file']) {
            echo "
        <li>";
            // line 86
            echo $this->getAttribute((isset($context['file']) ? $context['file'] : null), "name", array(), "array");
            echo "  
            <a href=\"#\" onClick=\"attachFile(";
            // line 87
            echo $this->getAttribute((isset($context['file']) ? $context['file'] : null), "attachment_id", array(), "array");
            echo ")\" id=\"attach_link_";
            echo $this->getAttribute((isset($context['file']) ? $context['file'] : null), "attachment_id", array(), "array");
            echo "\">Прикрепить</a>
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
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['file'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 89
        echo "
    </ul>
</div>";
    }

}
