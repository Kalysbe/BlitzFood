<?php

/* modules/BusinessReports/List.html */
class __TwigTemplate_7fb59cff97211a6aa06f6f54134582a3 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<div align=\"center\">
";
        // line 2
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
            // line 3
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/";
            echo (isset($context['lang_code']) ? $context['lang_code'] : null);
            echo "/";
            echo $this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Uname", array(), "any");
            echo "/Page:";
            echo (isset($context['page']) ? $context['page'] : null);
            echo "\" style=\"text-decoration: none;\">[ ";
            echo (isset($context['page']) ? $context['page'] : null);
            echo " ] </a>
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
        // line 4
        echo "
</div>



<div class=\"search\">
\t\t\t\t<form method=\"post\" action=\"";
        // line 10
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Search\" class=\"f_l form_search\">
\t\t\t\t\t<input type=\"text\" name=\"search\" class=\"src_txt f_l search_ipt\" style=\"float: none;width: 238px\" placeholder=\"Поиск по эмитенту\" autocomplete=\"off\" />
\t\t\t\t\t
\t\t\t\t\t<input type=\"submit\" class=\"src_btn f_l\" style=\"float: none\" value=\"\" /> <br/>
\t\t\t\t\t<ul class=\"search_result\" style=\"width: 238px;position: absolute\"></ul>
\t\t\t\t</form>
</div>
<script>
\$(function(){
    
//Г†ГЁГўГ®Г© ГЇГ®ГЁГ±ГЄ
\$('.search_ipt').bind(\"keyup\", function() {
\tvar text = \$(this).val();
\tif(text.length >= 2){
            \$.ajax({
            \ttype: 'POST',
            \turl: \"";
        // line 26
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Search\", //ГЏГіГІГј ГЄ Г®ГЎГ°Г ГЎГ®ГІГ·ГЁГЄГі
            \tdata: { 'referal' : text },
            \tresponse: 'text',
            \tsuccess: function(data) {
\t\t\t\$(\".search_result\").html(data).fadeIn();
\t\t\t\$(\".search_result li\").click(function() {
\t\t\t\tvar s_user = \$(this).text();
    \t\t\t\t\$(\".search_result\").fadeOut();
\t\t\t\t\$('.search_ipt').val(s_user);
\t\t\t}) 
           \t}
       \t    })
\t} else 
\t\t\$(\".search_result\").fadeOut();


})
    
\$(\".search_result\").hover(function(){
    \$(\".search_ipt\").blur(); //Г“ГЎГЁГ°Г ГҐГ¬ ГґГ®ГЄГіГ± Г± input
})


})
</script>
<br> <div class=\"info\" style=\"margin: 4% 0\">
        <p>
            Для публикации периодической отчетности и информации о существенных фактах эмитенты могут воспользоваться электронной системой
            ЗАО \"Кыргызская фондовая биржа\" по ссылке <a target=\"_blank\" href=\"https://oi.kse.kg/\">oi.kse.kg</a>. <br>
            Получить доступ (Логин, Пароль) к личному кабинету эмитента можно в Департаменте раскрытия информации ЗАО \"Кыргызская фондовая биржа\" по телефону: (0312) 31-15-01.
        </p>
    </div>
    <table width=\"100%\" class=\"class1\">

    <tr>
        <th style=\"text-transform: capitalize;\">наименование</th>
    </tr>
    ";
        // line 63
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['CompaniesList']) ? $context['CompaniesList'] : null));
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
    <tr>
        <td><a href=\"";
            // line 65
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/";
            echo (isset($context['lang_code']) ? $context['lang_code'] : null);
            echo "/";
            echo (isset($context['this_page']) ? $context['this_page'] : null);
            echo "/";
            echo $this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "name", array(), "array");
            echo "\">";
            echo $this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "title", array(), "array");
            echo "</a></td>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Company'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 67
        echo "
</table>

<div align=\"center\">
";
        // line 71
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
            // line 72
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/";
            echo (isset($context['lang_code']) ? $context['lang_code'] : null);
            echo "/";
            echo $this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Uname", array(), "any");
            echo "/Page:";
            echo (isset($context['page']) ? $context['page'] : null);
            echo "\" style=\"text-decoration: none;\">[ ";
            echo (isset($context['page']) ? $context['page'] : null);
            echo " ] </a>
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
        // line 73
        echo "
</div>

";
        // line 76
        if ((isset($context['Logged']) ? $context['Logged'] : null)) {
            echo "
<form action=\"\" method=\"POST\">
<div style=\"clear: both; width: 100%; padding: 15px; border: 1px solid #CCCCCC\" class=\"ui-corner-all\">
    <h2>Г„Г®ГЎГ ГўГЁГІГј ГЄГ®Г¬ГЇГ Г­ГЁГѕ</h2>
    <table width=\"45%\" class=\"class1\">
        <tr>
            <td>Г€Г¬Гї Г­Г  Г«Г ГІГЁГ­ГЁГ¶ГҐ (ГЎГҐГ§ ГЇГ°Г®ГЎГҐГ«Г®Гў, Г­Г ГЇГ°ГЁГ¬ГҐГ° my_company)</td>
            <td><input type=\"text\" name=\"name\" value=\"\" /></td>
        </tr>
        <tr>
            <td>ГЌГ ГЁГ¬ГҐГ­Г®ГўГ Г­ГЁГҐ ГЄГ®Г¬ГЇГ Г­ГЁГЁ</td>
            <td><input type=\"text\" name=\"title\" value=\"\" /></td>
        </tr>
    </table>
    <input type=\"submit\" name=\"doAddCompany\" value=\"Г„Г®ГЎГ ГўГЁГІГј\" />
</div>
</form>
";
        }
    }

}
