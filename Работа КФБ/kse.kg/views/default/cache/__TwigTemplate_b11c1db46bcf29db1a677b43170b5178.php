<?php

/* modules/BusinessCatalog/BusinessCatalog.html */
class __TwigTemplate_b11c1db46bcf29db1a677b43170b5178 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "
<script type=\"text/javascript\">

\$(function(){

            \$(\".company_description\").dialog({
                autoOpen: false,
                height: 250,
                width: 400,
                modal: true,
                title: \"Описание\",
                buttons: {
                    \"";
        // line 13
        echo $this->getAttribute((isset($context['Lang']) ? $context['Lang'] : null), "{doCancel}", array(), "array");
        echo "\": function() {
                            \$(this).dialog('close');
                    }
                },
                close: function() {
                        //allFields.val('').removeClass('ui-state-error');
                }
            });



});

function openInfo(id) {

    \$(\"#company_description\"+id).dialog('open');

}

</script>

<ul>
";
        // line 35
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['BusinessCatalog']) ? $context['BusinessCatalog'] : null));
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
    <li>
        ";
            // line 37
            if ($this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "text", array(), "array") != "") {
                echo "
        <a href=\"#\" onClick=\"openInfo(";
                // line 38
                echo $this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "id", array(), "array");
                echo ")\">
        ";
            }
            // line 39
            echo "
            ";
            // line 40
            echo $this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "title", array(), "array");
            echo "
        ";
            // line 41
            if ($this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "text", array(), "array") != "") {
                echo "
        </a>
        ";
            }
            // line 43
            echo "

        <div id=\"company_description";
            // line 45
            echo $this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "id", array(), "array");
            echo "\" class=\"company_description\">
            ";
            // line 46
            echo $this->getAttribute((isset($context['Company']) ? $context['Company'] : null), "text", array(), "array");
            echo "
        </div>
        
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Company'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 50
        echo "
</ul>
<br /><br /><br />
";
        // line 53
        if ((isset($context['Logged']) ? $context['Logged'] : null)) {
            echo "
<h2>Добавить компанию</h2>
<form action=\"/modules/BusinessCatalog/BusinessCatalog.php\" method=\"POST\">
    <input type=\"text\" name=\"mName\" value=\"\" /><br />
    <textarea name=\"mText\" id=\"mText\"></textarea><br />
    <input type=\"submit\" name=\"doAdd\" value=\"Add\" />
    <input type=\"hidden\" name=\"mGroup\" value=\"";
            // line 59
            echo (isset($context['Group']) ? $context['Group'] : null);
            echo "\" />
</form>
";
        }
        // line 61
        echo "

<script type=\"text/javascript\">
    \$(document).ready(function() {
        \$(\"#mText\").ckeditor({language: 'ru'});
    });
</script>";
    }

}
