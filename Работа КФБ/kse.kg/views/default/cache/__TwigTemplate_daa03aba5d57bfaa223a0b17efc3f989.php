<?php

/* attachment.html */
class __TwigTemplate_daa03aba5d57bfaa223a0b17efc3f989 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<script type=\"text/javascript\">
    function onAddAttachmentField() {
        \$(\"#fileForm\").append('<input type=\"file\" name=\"' + new Date().getTime() + '\" value=\"\" />');
    }
</script>

<h3>Вложения</h3>
<div id=\"fileForm\">
    <input type=\"file\" name=\"mFile1\" value=\"\" />
</div>
<a href=\"#\" onClick=\"onAddAttachmentField()\">Добавить поле</a>

";
    }

}
