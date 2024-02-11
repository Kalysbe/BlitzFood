<?php

/* modules/Blogeng/ControlPanel.html */
class __TwigTemplate_a5c134dd466512a36d424a83481fc37b extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        if ((isset($context['Logged']) ? $context['Logged'] : null)) {
            echo "
<h3>Панель управления</h3>

";
            // line 4
            if ((isset($context['edit_form']) ? $context['edit_form'] : null)) {
                echo "
<div class=\"section\" id=\"fast_publication\" >
    <form action=\"\" method=\"POST\">
        <h3>Редактирование</h3><br />
        Заголовок: <input type=\"text\" name=\"title\" value=\"";
                // line 8
                echo $this->getAttribute((isset($context['edit_post']) ? $context['edit_post'] : null), "name", array(), "array");
                echo "\" style=\"width: 100%\" /><br /><br />
        Текст:<br /><textarea name=\"text\" id=\"mEntryText\">";
                // line 9
                echo $this->getAttribute((isset($context['edit_post']) ? $context['edit_post'] : null), "text", array(), "array");
                echo "</textarea>
        <script type=\"text/javascript\">
            \$(\"#mEntryText\").ckeditor();
        </script>
        <br />
        <label>Дата:</label>
        <p><input type=\"text\" name=\"cr_date\" value=\"";
                // line 15
                echo $this->getAttribute((isset($context['edit_post']) ? $context['edit_post'] : null), "cr_date", array(), "array");
                echo "\" id=\"mEntryDate\" /></p>
        <script type=\"text/javascript\">
            \$(\"#mEntryDate\").datepicker({dateFormat: 'yy-mm-dd'});
        </script>
        <br />
        <input type=\"submit\" name=\"do_edit_entry\" value=\"";
                // line 20
                echo $this->getAttribute((isset($context['land']) ? $context['land'] : null), "doSave", array(), "array");
                echo "\" />
        <input type=\"hidden\" name=\"blog_id\" value=\"";
                // line 21
                echo (isset($context['BlogId']) ? $context['BlogId'] : null);
                echo "\" />
        <input type=\"hidden\" name=\"cur_lang\" value=\"";
                // line 22
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "\" />
        <input type=\"hidden\" name=\"blogentry_id\" value=\"";
                // line 23
                echo $this->getAttribute((isset($context['edit_post']) ? $context['edit_post'] : null), "blogentry_id", array(), "array");
                echo "\" />
    </form>
</div>
";
            } else {
                // line 26
                echo "
<div class=\"section\" id=\"fast_publication\" >
    <form action=\"";
                // line 28
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/modules/Blog/ControlPanel.php\" method=\"POST\">
        <h3>Быстрая публикация</h3><br />
        Заголовок: <input type=\"text\" name=\"mEntryName\" value=\"\" style=\"width: 100%\" /><br /><br />
        Текст:<br /><textarea name=\"mEntryText\" id=\"mEntryText\"></textarea>
        <script type=\"text/javascript\">
            \$(\"#mEntryText\").ckeditor();
        </script>
        <br />
        <label>Дата:</label>
        <p><input type=\"text\" name=\"mEntryDate\" value=\"\" id=\"mEntryDate\" /></p>
        <script type=\"text/javascript\">
            \$(\"#mEntryDate\").datepicker({dateFormat: 'yy-mm-dd'});
        </script>
        <br />
        <input type=\"submit\" name=\"doAddEntry\" value=\"Добавить\" />
        <input type=\"hidden\" name=\"BlogId\" value=\"";
                // line 43
                echo (isset($context['BlogId']) ? $context['BlogId'] : null);
                echo "\" />
        <input type=\"hidden\" name=\"cur_lang\" value=\"";
                // line 44
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "\" />
    </form>
</div>

<h2 style=\"margin-top: 20px;\">&darr; Записи</h2>
<div style=\"margin-top: 0px; border-top: 3px solid #90AABB\">
    <br />
    ";
                // line 51
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_iterator_to_array((isset($context['Posts']) ? $context['Posts'] : null));
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
                foreach ($context['_seq'] as $context['_key'] => $context['Post']) {
                    echo "
        <li>
            <b>
                <p class=\"entry_title\"><b>";
                    // line 54
                    echo $this->getAttribute((isset($context['Post']) ? $context['Post'] : null), "Date", array(), "any");
                    echo "</b>
                    <a href=\"";
                    // line 55
                    echo (isset($context['root']) ? $context['root'] : null);
                    echo "/";
                    echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                    echo "/";
                    echo (isset($context['BlogName']) ? $context['BlogName'] : null);
                    echo "/ControlPanel/Edit/";
                    echo $this->getAttribute((isset($context['Post']) ? $context['Post'] : null), "Id", array(), "any");
                    echo "\">
                         ";
                    // line 56
                    echo $this->getAttribute((isset($context['Post']) ? $context['Post'] : null), "Title", array(), "any");
                    echo "
                    </a>
                </p>
                <p class=\"entry_meta\">

                </p>
            </b>
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
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Post'], $context['_parent'], $context['loop']);
                $context = array_merge($_parent, array_intersect_key($context, $_parent));
                // line 64
                echo "
    </ul>
</div>

";
                // line 68
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_iterator_to_array((isset($context['pages_list']) ? $context['pages_list'] : null));
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
                foreach ($context['_seq'] as $context['_key'] => $context['page']) {
                    echo "
<a href=\"";
                    // line 69
                    echo (isset($context['root']) ? $context['root'] : null);
                    echo "/";
                    echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                    echo "/";
                    echo (isset($context['BlogName']) ? $context['BlogName'] : null);
                    echo "/ControlPanel/";
                    echo (isset($context['page']) ? $context['page'] : null);
                    echo "\"> ";
                    echo (isset($context['page']) ? $context['page'] : null);
                    echo " </a>
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
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['page'], $context['_parent'], $context['loop']);
                $context = array_merge($_parent, array_intersect_key($context, $_parent));
                // line 70
                echo "

";
            }
            // line 72
            echo "

";
        } else {
            // line 74
            echo "
<div class=\"error ui-corner-all\">
    <h3>У Вас нет доступа в эту область</h3>
    <p></p>
</div>
";
        }
    }

}
