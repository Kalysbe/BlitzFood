<?php

/* modules/Blog/ControlPanel.html */
class __TwigTemplate_f1ddcfb712355bf45706e1841d5b867f extends Twig_Template
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
            CKEDITOR.replace( \"text\" );
        </script>
        <br />
        <p><label>Дата:</label>
        <input type=\"text\" name=\"cr_date\" value=\"";
                // line 15
                echo $this->getAttribute((isset($context['edit_post']) ? $context['edit_post'] : null), "cr_date", array(), "array");
                echo "\" id=\"mEntryDate\" />
        <script type=\"text/javascript\">
            \$(\"#mEntryDate\").datepicker({dateFormat: 'yy-mm-dd'});
        </script>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
\t\t<label>Компания:</label>
\t\t\t
\t\t<select name=\"mEntryCompany\" id=\"mEntryCompany\">
\t\t<option value=\"0\" selected>нет
\t\t\t";
                // line 23
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_iterator_to_array((isset($context['sprCompanys']) ? $context['sprCompanys'] : null));
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
                foreach ($context['_seq'] as $context['_key'] => $context['Company']) {
                    echo "
\t\t\t<option value=";
                    // line 24
                    echo $this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "company_id", array(), "any");
                    echo " ";
                    if ($this->getAttribute((isset($context['edit_post']) ? $context['edit_post'] : null), "l_company_id", array(), "array") == $this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "company_id", array(), "any")) {
                        echo " SELECTED ";
                    }
                    echo ">";
                    echo $this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "title", array(), "any");
                    echo "
\t\t\t";
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
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Company'], $context['_parent'], $context['loop']);
                $context = array_merge($_parent, array_intersect_key($context, $_parent));
                // line 25
                echo "
\t\t</select> </p>\t\t
        <br />
        <input type=\"submit\" name=\"do_edit_entry\" value=\"";
                // line 28
                echo $this->getAttribute((isset($context['land']) ? $context['land'] : null), "doSave", array(), "array");
                echo "\" />
        <input type=\"hidden\" name=\"blog_id\" value=\"";
                // line 29
                echo (isset($context['BlogId']) ? $context['BlogId'] : null);
                echo "\" />
        <input type=\"hidden\" name=\"cur_lang\" value=\"";
                // line 30
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "\" />
        <input type=\"hidden\" name=\"blogentry_id\" value=\"";
                // line 31
                echo $this->getAttribute((isset($context['edit_post']) ? $context['edit_post'] : null), "blogentry_id", array(), "array");
                echo "\" />
    </form>
</div>
";
            } else {
                // line 34
                echo "
<div class=\"section\" id=\"fast_publication\" >
    <form action=\"";
                // line 36
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/modules/Blog/ControlPanel.php\" method=\"POST\">
        <h3>Быстрая публикация</h3><br />
        Заголовок: <input type=\"text\" name=\"mEntryName\" value=\"\" style=\"width: 100%\" /><br /><br />
        Текст:<br /><textarea name=\"mEntryText\" id=\"mEntryText\"></textarea>
        <script type=\"text/javascript\">
            CKEDITOR.replace( \"mEntryText\" );
        </script>
        <br />
        <p><label>Дата:</label>
        <input type=\"text\" name=\"mEntryDate\" value=\"\" id=\"mEntryDate\" />
        <script type=\"text/javascript\">
            \$(\"#mEntryDate\").datepicker({dateFormat: 'yy-mm-dd'});
        </script>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
\t\t<label>Компания:</label>
\t\t\t
\t\t<select name=\"mEntryCompany\" id=\"mEntryCompany\">
\t\t<option value=\"0\" selected>нет
\t\t\t";
                // line 53
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_iterator_to_array((isset($context['sprCompanys']) ? $context['sprCompanys'] : null));
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
                foreach ($context['_seq'] as $context['_key'] => $context['Company']) {
                    echo "
\t\t\t\t<option value=";
                    // line 54
                    echo $this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "company_id", array(), "any");
                    echo ">";
                    echo $this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "title", array(), "any");
                    echo "
\t\t\t";
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
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Company'], $context['_parent'], $context['loop']);
                $context = array_merge($_parent, array_intersect_key($context, $_parent));
                // line 55
                echo "
\t\t</select> </p>
\t\t\t
        <br />
        <input type=\"submit\" name=\"doAddEntry\" value=\"Добавить\" />
        <input type=\"hidden\" name=\"BlogId\" value=\"";
                // line 60
                echo (isset($context['BlogId']) ? $context['BlogId'] : null);
                echo "\" />
        <input type=\"hidden\" name=\"cur_lang\" value=\"";
                // line 61
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "\" />
    </form>
</div>

<h2 style=\"margin-top: 20px;\">&darr; Записи</h2>
<div style=\"margin-top: 0px; border-top: 3px solid #90AABB\">
    <br />
    ";
                // line 68
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
                    // line 71
                    echo $this->getAttribute((isset($context['Post']) ? $context['Post'] : null), "Date", array(), "any");
                    echo "</b>
                   <!-- <a href=\"";
                    // line 72
                    echo (isset($context['root']) ? $context['root'] : null);
                    echo "/";
                    echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                    echo "/";
                    echo (isset($context['BlogName']) ? $context['BlogName'] : null);
                    echo "/ControlPanel/Edit/";
                    echo $this->getAttribute((isset($context['Post']) ? $context['Post'] : null), "Id", array(), "any");
                    echo "\"> -->
                         ";
                    // line 73
                    echo $this->getAttribute((isset($context['Post']) ? $context['Post'] : null), "Title", array(), "any");
                    echo "
                    <!-- </a>&nbsp -->
                    <a href=\"";
                    // line 75
                    echo (isset($context['root']) ? $context['root'] : null);
                    echo "/";
                    echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                    echo "/";
                    echo (isset($context['BlogName']) ? $context['BlogName'] : null);
                    echo "/ControlPanel/Edit/";
                    echo $this->getAttribute((isset($context['Post']) ? $context['Post'] : null), "Id", array(), "any");
                    echo "\">
\t\t\t          <img src=\"";
                    // line 76
                    echo (isset($context['root']) ? $context['root'] : null);
                    echo "/files/images/edit-icon.png\" />
                    </a>&nbsp

\t\t      <a href=\"";
                    // line 79
                    echo (isset($context['root']) ? $context['root'] : null);
                    echo "/";
                    echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                    echo "/";
                    echo (isset($context['BlogName']) ? $context['BlogName'] : null);
                    echo "/ControlPanel/Delete/";
                    echo $this->getAttribute((isset($context['Post']) ? $context['Post'] : null), "Id", array(), "any");
                    echo "\">
                      <img src=\"";
                    // line 80
                    echo (isset($context['root']) ? $context['root'] : null);
                    echo "/files/images/delete-icon.png\" />
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
                // line 89
                echo "
    </ul>
</div>

";
                // line 93
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
                    // line 94
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
                // line 95
                echo "

";
            }
            // line 97
            echo "

";
        } else {
            // line 99
            echo "
<div class=\"error ui-corner-all\">
    <h3>У Вас нет доступа в эту область</h3>
    <p></p>
</div>
";
        }
    }

}
