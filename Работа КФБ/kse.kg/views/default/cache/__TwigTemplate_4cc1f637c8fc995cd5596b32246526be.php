<?php

/* inner_attachment.html */
class __TwigTemplate_4cc1f637c8fc995cd5596b32246526be extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
    <meta property=”og:image” content=\"";
        // line 5
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/logo_meta.png\" /> <!-- для Facebook -->
\t<title>Kyrgyz Stock Exchange</title>
        <link rel=\"shortcut icon\" type=\"image/x-png\" href=\"";
        // line 7
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/favicon.png\" />
\t<link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 8
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/styles/style.css\" />
        <link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 9
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/styles/common.css\" />
\t<link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 10
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/styles/scroller.css\" />
\t<!--[if IE 6]><body class=\"ie6\"><![endif]-->
\t<!--[if IE 7]><body class=\"ie7\"><![endif]-->
\t";
        // line 13
        echo "

        <link type=\"text/css\" href=\"";
        // line 15
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/scripts/jquery-ui/css/buse/jquery-ui.css\" rel=\"Stylesheet\" />
        <script type=\"text/javascript\" src=\"";
        // line 16
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/scripts/jquery-ui/js/jquery-1.4.2.min.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 17
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/scripts/jquery-ui/js/jquery-ui.min.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 18
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/scripts/ckeditor/ckeditor.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 19
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/scripts/ckeditor/adapters/jquery.js\"></script>
        <script type=\"text/javascript\">
                    var timeout    = 500;
                    var closetimer = 0;
                    var ddmenuitem = 0;

                    function jsddm_open()
                    {  jsddm_canceltimer();
                       jsddm_close();
                       ddmenuitem = \$(this).find('ul').css('visibility', 'visible');}

                    function jsddm_close()
                    {  if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');}

                    function jsddm_timer()
                    {  closetimer = window.setTimeout(jsddm_close, timeout);}

                    function jsddm_canceltimer()
                    {  if(closetimer)
                       {  window.clearTimeout(closetimer);
                          closetimer = null;}}

                    \$(document).ready(function()
                    {
                        \$('#jsddm > li').bind('mouseover', jsddm_open)
                       \$('#jsddm > li').bind('mouseout',  jsddm_timer)
                    }

                    );

                    document.onclick = jsddm_close;

                </script>
        <script type=\"text/javascript\">
        \$(function() {

            \$(\"input:submit\").button();

            var tips = \$(\".validateTips\");
            function updateTips(t) {
                tips
                    .text(t)
                    .addClass('ui-state-highlight');
                setTimeout(function() {
                    tips.removeClass('ui-state-highlight', 1500);
                }, 500);
            }

            function doLogIn() {
                \$.post(\"";
        // line 68
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/handlers/login.php\", {
                    doLogin: 1,
                    mLogin: \$(\"#mLogin\").val(),
                    mPass: \$(\"#mPass\").val()
                }, function(result) {
                    if (result == 0) {
                        updateTips(\"<div class='error'>";
        // line 74
        echo $this->getAttribute((isset($context['Lang']) ? $context['Lang'] : null), "{BadLoginOrPassword}", array(), "array");
        echo "</div>\");
                    } else if (result == 1) {
                        window.location.replace(\"";
        // line 76
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/";
        echo (isset($context['main_page']) ? $context['main_page'] : null);
        echo "\");
                    }
                });
            }

            \$(\"#login-dialog\").dialog({
                autoOpen: false,
                height: 250,
                width: 400,
                modal: true,
                title: \"";
        // line 86
        echo $this->getAttribute((isset($context['Lang']) ? $context['Lang'] : null), "{LogInButton}", array(), "array");
        echo "\",
                buttons: {
                    \"";
        // line 88
        echo $this->getAttribute((isset($context['Lang']) ? $context['Lang'] : null), "{doLogIn}", array(), "array");
        echo "\": function() {
                        doLogIn();
                    },
                    \"";
        // line 91
        echo $this->getAttribute((isset($context['Lang']) ? $context['Lang'] : null), "{doCancel}", array(), "array");
        echo "\": function() {
                            \$(this).dialog('close');
                    }
                },
                close: function() {
                        allFields.val('').removeClass('ui-state-error');
                }
            });

            \$('#loginButton')
            .click(function() {
                    \$('#login-dialog').dialog('open');
            });

        });

    </script>

    <script type=\"text/javascript\" src=\"";
        // line 109
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/js/scroll.js\"></script>
    ";
        // line 110
        $this->env->loadTemplate("common_head.html")->display($context);
        echo "
</head>
<body>

<div id=\"body\">
\t<div class=\"header\">
\t\t<h1>
\t\t\t<a href=\"";
        // line 117
        echo (isset($context['root']) ? $context['root'] : null);
        echo "\"><img src=\"";
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/logo_KSE.jpg\" border=\"0\"/></a>
\t\t\t<span class=\"sitename\">Кыргызская Фондовая Биржа</span>
\t\t</h1>
\t\t<div class=\"header_right\">
\t\t\t<div class=\"search\">
\t\t\t\t<form action=\"/\" class=\"f_l\">
\t\t\t\t\t<input type=\"text\" class=\"src_txt f_l\" value=\"Поиск по сайту\" onfocus=\"this.value=''\" />
\t\t\t\t\t<input type=\"button\" class=\"src_btn f_l\" value=\"\" />
\t\t\t\t\t<a href=\"";
        // line 125
        echo (isset($context['root']) ? $context['root'] : null);
        echo "\" class=\"def_menu\"><img src=\"";
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/icon_home.jpg\"/></a>
\t\t\t\t\t<a href=\"#\" class=\"def_menu\"><img src=\"";
        // line 126
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/icon_mail.jpg\"/></a>
                                        ";
        // line 127
        if ((isset($context['Logged']) ? $context['Logged'] : null)) {
            echo "
                                        <a href=\"";
            // line 128
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/handlers/logout.php\" class=\"def_menu\">";
            echo $this->getAttribute((isset($context['LoggedUser']) ? $context['LoggedUser'] : null), "getUsername", array(), "any");
            echo "</a>
                                        ";
        } else {
            // line 129
            echo "
\t\t\t\t\t<a href=\"#\" class=\"def_menu\" id=\"loginButton\"><img src=\"";
            // line 130
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/views/kse/images/icon_key.jpg\"/></a>
                                        ";
        }
        // line 131
        echo "
\t\t\t\t</form>
\t\t\t\t<div class=\"lang\">
\t\t\t\t\t<ul class=\"lang\">
\t\t\t\t\t\t<li><a href=\"";
        // line 135
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/ru/MainPage\" class=\"selected\">Рус</a></li>
\t\t\t\t\t\t<li><a href=\"";
        // line 136
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/ky/MainPage\">Кыр</a></li>
\t\t\t\t\t\t<li><a href=\"";
        // line 137
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/en/MainPage\">Eng</a></li>
\t\t\t\t\t</ul>
\t\t\t\t</div><!--/lang-->
\t\t\t</div><!--/search-->
\t\t</div><!--/header_right-->
\t\t<div class=\"banner_top\">
\t\t\t<a href=\"";
        // line 143
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/FinMarket\"><img src=\"";
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/banner_top.jpg\" border=\"0\"/></a>
\t\t</div><!--/banner_top-->
\t\t<div class=\"clear\"><img src=\"";
        // line 145
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/pixel.gif\" /></div>
\t\t<div class=\"kse_marquee\">
\t\t\t<ul class=\"kse_marquee\" id=\"QuatationsOnline\">
                                ";
        // line 148
        echo $this->getAttribute((isset($context['ViewsPage_KseScroll']) ? $context['ViewsPage_KseScroll'] : null), "Text", array(), "any");
        echo "

\t\t\t</ul>
                    <script type=\"text/javascript\">
                        ";
        // line 154
        echo "
                    </script>

\t\t</div><!--/marquee-->
\t</div><!--/header-->
\t<div class=\"topmenu\">
\t\t";
        // line 160
        $this->env->loadTemplate("topmenu.html")->display($context);
        echo "
\t</div><!--/topmenu-->
\t<div class=\"content_block\">
\t\t<div class=\"left\">
                    ";
        // line 164
        echo $this->getAttribute((isset($context['ViewsPage_KseMenu']) ? $context['ViewsPage_KseMenu'] : null), "Text", array(), "any");
        echo "
                    ";
        // line 217
        echo "
\t\t</div><!--left-->
\t\t<div class=\"center\">
\t<div class=\"fcc\">
\t    ";
        // line 221
        echo (isset($context['SapeCode']) ? $context['SapeCode'] : null);
        echo "
\t</div>

\t\t\t ";
        // line 224
        if ($this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Status", array(), "any") == 4) {
            echo "
                          ";
            // line 225
            $template = $this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Text", array(), "any");
            if (!$template instanceof Twig_Template) {
                $template = $this->env->loadTemplate($template);
            }
            $template->display($context);
            echo "
                          ";
        } elseif ($this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Status", array(), "any") == 8) {
            // line 226
            echo "
                          ";
            // line 227
            $template = (isset($context['ControllerInclusion']) ? $context['ControllerInclusion'] : null);
            if (!$template instanceof Twig_Template) {
                $template = $this->env->loadTemplate($template);
            }
            $template->display($context);
            echo "
                          ";
        } else {
            // line 228
            echo "
                          <div class=\"page_text\">";
            // line 229
            echo $this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Text", array(), "any");
            echo "</div>
                          ";
            // line 230
            if (((isset($context['Logged']) ? $context['Logged'] : null)) && ($this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Status", array(), "any") == 1)) {
                echo "
                          <div class=\"buse_page_meta\">
                              <ul>
                                  <li class=\"ui-corner-all\"><a href=\"";
                // line 233
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/";
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "/EditPage/";
                echo $this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Uname", array(), "any");
                echo "\">Редактировать</a></li>
                                  <li class=\"ui-corner-all\"><a href=\"";
                // line 234
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/";
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "/RenamePage/";
                echo $this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Uname", array(), "any");
                echo "\">Переименовать</a></li>
                                  <li class=\"ui-corner-all\"><a href=\"";
                // line 235
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/";
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "/HidePage/";
                echo $this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Uname", array(), "any");
                echo "\">Скрыть</a></li>
                              </ul>
                          </div>
                          ";
            }
            // line 238
            echo "
                          ";
        }
        // line 239
        echo "
\t\t</div><!--/center-->
\t\t<div class=\"right\">
\t\t\t<div class=\"docs\">
\t\t\t\t<ul class=\"docs\">
                                    ";
        // line 244
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['Attachments']) ? $context['Attachments'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['Attachment']) {
            echo "
                                    <li>
                                        <p class=\"grey\">";
            // line 246
            echo $this->getAttribute((isset($context['Attachment']) ? $context['Attachment'] : null), "Description", array(), "any");
            echo "</p>
                                        <div class=\"pdf_link\">
                                            <a href=\"";
            // line 248
            echo (isset($context['root']) ? $context['root'] : null);
            echo $this->getAttribute((isset($context['Attachment']) ? $context['Attachment'] : null), "Filepath", array(), "any");
            echo $this->getAttribute((isset($context['Attachment']) ? $context['Attachment'] : null), "Filename", array(), "any");
            echo "\" class=\"f_l\">
                                                <img src=\"";
            // line 249
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/views/kse/images/";
            echo $this->getAttribute((isset($context['Attachment']) ? $context['Attachment'] : null), "Icon", array(), "any");
            echo "\" border=\"0\" alt=\"";
            echo $this->getAttribute((isset($context['Attachment']) ? $context['Attachment'] : null), "Name", array(), "any");
            echo "\"/></a>
                                            <a href=\"";
            // line 250
            echo (isset($context['root']) ? $context['root'] : null);
            echo $this->getAttribute((isset($context['Attachment']) ? $context['Attachment'] : null), "Filepath", array(), "any");
            echo $this->getAttribute((isset($context['Attachment']) ? $context['Attachment'] : null), "Filename", array(), "any");
            echo "\" class=\"bullet_link pdf_link\">Приложение</a>
                                            <p class=\"pdf_size\">";
            // line 251
            echo $this->getAttribute((isset($context['Attachment']) ? $context['Attachment'] : null), "Size", array(), "any");
            echo "</p>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Attachment'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 254
        echo "
\t\t\t\t</ul><!--/docs-->
\t\t\t</div><!--/docs-->
\t\t\t<div class=\"banner_inner_right\">
\t\t\t\t
\t\t\t</div><!--/banner_inner_right-->
\t\t</div><!--/right-->

\t\t<div class=\"clear\"><img src=\"";
        // line 262
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/pixel.gif\" /></div>
\t</div><!--/content_block-->
</div><!--/body-->
<div class=\"clear\"><img src=\"";
        // line 265
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/pixel.gif\" /></div>
<div id=\"footer\">
\t<div class=\"footer_content\">
\t\t<div class=\"footer_inner\">
\t\t\t<div class=\"footer_left\">

\t\t\t\t<p class=\"footer\">ЗАО \"Кыргызская Фондовая Биржа\"</p>
                                <p>720010 Кыргызская Республика, <br />г. Бишкек, ул. Московская, 172, +996 312 31 14 84</p>
\t\t\t\t<p class=\"footer\">Электронная почта: <a href=\"mailto:office@kse.kg\" class=\"mail\">office@kse.kg</a></p>
                <p> <a href=\"http://www.kse.kg/views/kse/templates/modules/Rss/rss.php\" target=\"_blank\">Rss новости</a></p>
\t\t\t</div><!--/footer_left-->
\t\t\t<div class=\"footer_right\">
                            <p class=\"footer\">Все права защищены © 2004-2019</p>
\t\t\t\t\t\t\t<p class=\"footer\">Копирование материалов – только с письменного разрешения.</p>
\t\t\t\t<p class=\"footer\">Лицензия №37 НКРЦБ от 30.11.2000 г.</p>
\t\t\t\t<!--<a href=\"#\" class=\"counter\">&nbsp;</a>-->
\t\t\t</div><!--/footer_right-->
\t\t</div><!--/footer_inner-->
\t</div><!--/footer_content-->
</div><!--/footer-->
<div id=\"login-dialog\">
            <p class=\"validateTips\"></p>
            <div id=\"two_columns\">
                <label>Логин:</label>
                <input type=\"text\" name=\"mLogin\" value=\"\" id=\"mLogin\" class=\"text ui-widget-content ui-corner-all\" />
                <label>Пароль:</label>
                <input type=\"password\" name=\"mPass\" value=\"\" id=\"mPass\" class=\"text ui-widget-content ui-corner-all\" />
            </div>
        </div>
</body>
</html>";
    }

}
