<?php

/* main.html */
class __TwigTemplate_0c53ddf78f30edfd10c0e5980d324de7 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
\t<meta property=”og:image” content=\"";
        // line 5
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/logo_meta.png\" /> <!-- для Facebook -->
\t<title>Главная :: Kyrgyz Stock Exchange</title>
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
\t<script type=\"text/javascript\" src=\"";
        // line 13
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/scripts/jquery.js\"></script>
\t
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
\t\t<script language=\"Javascript\" src=\"";
        // line 20
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/lib/JSd3/d3.min.js\"></script>
\t\t<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script> 
\t\t
        <script type=\"text/javascript\">
                    var timeout    = 500;
                    var closetimer = 0;
                    var ddmenuitem = 0;

                    function jsddm_open() {
                        jsddm_canceltimer();
                        jsddm_close();
                        ddmenuitem = \$(this).find('ul').css('visibility', 'visible');
                    }

                    function jsddm_close() {
                        if (ddmenuitem)
                            ddmenuitem.css('visibility', 'hidden');
                    }

                    function jsddm_timer() {
                        closetimer = window.setTimeout(jsddm_close, timeout);
                    }

                    function jsddm_canceltimer() {
                        if(closetimer) {
                            window.clearTimeout(closetimer);
                            closetimer = null;
                        }
                    }

                    \$(document).ready(function() {
                            \$('#jsddm > li').bind('mouseover', jsddm_open);
                            \$('#jsddm > li').bind('mouseout',  jsddm_timer);
                            
                        }
                    );

                    document.onclick = jsddm_close;
                </script>
        <script type=\"text/javascript\">
        \$(function() {


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
        // line 74
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/handlers/login.php\", {
                    doLogin: 1,
                    mLogin: \$(\"#mLogin\").val(),
                    mPass: \$(\"#mPass\").val()
                }, function(result) {
                    console.log(result);
\t\t\t\t\tif (result == 0) {
                        updateTips(\"<div class='error'>";
        // line 81
        echo $this->getAttribute((isset($context['Lang']) ? $context['Lang'] : null), "{BadLoginOrPassword}", array(), "array");
        echo "</div>\");
                    } else if (result == 1) {
                        window.location.replace(\"";
        // line 83
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
        // line 93
        echo $this->getAttribute((isset($context['Lang']) ? $context['Lang'] : null), "{LogInButton}", array(), "array");
        echo "\",
                buttons: {
                    \"";
        // line 95
        echo $this->getAttribute((isset($context['Lang']) ? $context['Lang'] : null), "{doLogIn}", array(), "array");
        echo "\": function() {
                        doLogIn();
                    },
                    \"";
        // line 98
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
        // line 116
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/js/scroll.js\"></script>
    ";
        // line 117
        $this->env->loadTemplate("common_head.html")->display($context);
        echo "
</head>
<body>
\t\t<div class=\"fcc\">
\t    ";
        // line 121
        echo (isset($context['SapeCode']) ? $context['SapeCode'] : null);
        echo "
\t</div>\t

<div id=\"body\">
\t<div class=\"header\">
\t\t<h1>
\t\t\t<a href=\"";
        // line 127
        echo (isset($context['root']) ? $context['root'] : null);
        echo "\"><img src=\"";
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/logo_KSE.jpg\" border=\"0\"/></a>
\t\t\t<span class=\"sitename\">Кыргызская Фондовая Биржа</span>
\t\t</h1>
\t\t<div class=\"header_right\">
\t\t\t<div class=\"search\">
\t\t\t\t<form method=\"POST\" action=\"";
        // line 132
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Search\" class=\"f_l\">
\t\t\t\t\t<input type=\"text\" name=\"search_top\" class=\"src_txt f_l\" value=\"Поиск по сайту\" onfocus=\"this.value=''\" />
\t\t\t\t\t<input type=\"submit\" class=\"src_btn f_l\" value=\"\" />
\t\t\t\t\t
\t\t\t\t\t<a href=\"";
        // line 136
        echo (isset($context['root']) ? $context['root'] : null);
        echo "\" class=\"def_menu\"><img src=\"";
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/icon_home.jpg\"/></a>
\t\t\t\t\t<a href=\"#\" class=\"def_menu\"><img src=\"";
        // line 137
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/icon_mail.jpg\"/></a>
                                        ";
        // line 138
        if ((isset($context['Logged']) ? $context['Logged'] : null)) {
            echo "
                                        <a href=\"";
            // line 139
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/handlers/logout.php\" class=\"def_menu\">";
            echo $this->getAttribute((isset($context['LoggedUser']) ? $context['LoggedUser'] : null), "getUsername", array(), "any");
            echo "</a>
                                        ";
        } else {
            // line 140
            echo "
\t\t\t\t\t<a href=\"#\" class=\"def_menu\" id=\"loginButton\"><img src=\"";
            // line 141
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/views/kse/images/icon_key.jpg\"/></a>
                                        ";
        }
        // line 142
        echo "
\t\t\t\t</form>
\t\t\t\t<div class=\"lang\">
\t\t\t\t\t<ul class=\"lang\">
\t\t\t\t\t\t<li><a href=\"";
        // line 146
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/ru/MainPage\" ";
        if ((isset($context['lang_code']) ? $context['lang_code'] : null) == "ru") {
            echo "class=\"selected\"";
        }
        echo ">Рус</a></li>
\t\t\t\t\t\t<li><a href=\"";
        // line 147
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/ky/MainPage\" ";
        if ((isset($context['lang_code']) ? $context['lang_code'] : null) == "ky") {
            echo "class=\"selected\"";
        }
        echo ">Кыр</a></li>
\t\t\t\t\t\t<li><a href=\"";
        // line 148
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/en/MainPage\" ";
        if ((isset($context['lang_code']) ? $context['lang_code'] : null) == "en") {
            echo "class=\"selected\"";
        }
        echo ">Eng</a></li>
\t\t\t\t\t</ul>
\t\t\t\t</div><!--/lang-->
\t\t\t</div><!--/search-->
\t\t</div><!--/header_right-->
\t\t<div class=\"banner_top\">
\t\t\t<a href=\"";
        // line 154
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Finmarket\"><img src=\"";
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/banner_top.jpg\" border=\"0\"/></a>
\t\t</div><!--/banner_top-->
\t\t<div class=\"fcc\">
\t    ";
        // line 157
        echo (isset($context['SapeCode']) ? $context['SapeCode'] : null);
        echo "
\t</div>\t
\t\t<!--<div class=\"banner_yub\">енравпр
\t\t\t<a href=\"";
        // line 160
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/";
        echo (isset($context['lang_code']) ? $context['lang_code'] : null);
        echo "/Announcement\"><img src=\"";
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/banner_yub.jpg\" border=\"0\"/></a>
\t\t</div><!--/banner_yub-->
\t\t
\t\t<div class=\"clear\"><img src=\"";
        // line 163
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/pixel.gif\" /></div>
\t\t<div class=\"kse_marquee\">
\t\t\t<ul class=\"kse_marquee\" id=\"QuatationsOnline\">
\t\t\t\t";
        // line 171
        echo "
                                ";
        // line 172
        echo $this->getAttribute((isset($context['ViewsPage_KseScroll']) ? $context['ViewsPage_KseScroll'] : null), "Text", array(), "any");
        echo "

\t\t\t</ul>
                    
                    
\t\t</div><!--/marquee-->
\t</div><!--/header-->
\t<div class=\"topmenu\">
\t\t";
        // line 180
        $this->env->loadTemplate("topmenu.html")->display($context);
        echo "
\t</div><!--/topmenu-->
\t<div class=\"content_block\">
\t\t<div class=\"left\">
                    ";
        // line 184
        echo $this->getAttribute((isset($context['ViewsPage_KseMenu']) ? $context['ViewsPage_KseMenu'] : null), "Text", array(), "any");
        echo "
                    ";
        // line 237
        echo "
\t\t</div><!--left-->
\t\t<div class=\"center\">
\t<div class=\"fcc\">
\t    ";
        // line 241
        echo (isset($context['SapeCode']) ? $context['SapeCode'] : null);
        echo "
\t</div>

\t\t\t ";
        // line 244
        if ($this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Status", array(), "any") == 4) {
            echo "
                ";
            // line 245
            $template = $this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Text", array(), "any");
            if (!$template instanceof Twig_Template) {
                $template = $this->env->loadTemplate($template);
            }
            $template->display($context);
            echo "
             ";
        } elseif ($this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Status", array(), "any") == 8) {
            // line 246
            echo "
                ";
            // line 247
            $template = (isset($context['ControllerInclusion']) ? $context['ControllerInclusion'] : null);
            if (!$template instanceof Twig_Template) {
                $template = $this->env->loadTemplate($template);
            }
            $template->display($context);
            echo "
             ";
        } else {
            // line 248
            echo "
                <div class=\"page_text\">";
            // line 249
            echo $this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Text", array(), "any");
            echo "</div>
                    ";
            // line 250
            if (((isset($context['Logged']) ? $context['Logged'] : null)) && ($this->getAttribute((isset($context['LoggedUser']) ? $context['LoggedUser'] : null), "getUsername", array(), "any") == "admin")) {
                echo "
\t\t                <div class=\"buse_page_meta\">
\t\t                    <ul>
\t\t                        <li class=\"ui-corner-all\"><a href=\"";
                // line 253
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/";
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "/EditPage/";
                echo $this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Uname", array(), "any");
                echo "\">Редактировать</a></li>
\t\t                        <li class=\"ui-corner-all\"><a href=\"";
                // line 254
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/";
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "/RenamePage/";
                echo $this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Uname", array(), "any");
                echo "\">Переименовать</a></li>
\t\t                        <li class=\"ui-corner-all\"><a href=\"";
                // line 255
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/";
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "/HidePage/";
                echo $this->getAttribute((isset($context['Page']) ? $context['Page'] : null), "Uname", array(), "any");
                echo "\">Скрыть</a></li>
\t\t                    </ul>
\t\t                </div>
                    ";
            }
            // line 258
            echo "
            ";
        }
        // line 259
        echo "
\t\t</div><!--/center-->
\t\t<div class=\"right\">
                    ";
        // line 262
        echo $this->getAttribute((isset($context['ViewsPage_KseRightSidebar']) ? $context['ViewsPage_KseRightSidebar'] : null), "Text", array(), "any");
        echo "
                    ";
        // line 286
        echo "
\t\t</div><!--/right-->
\t\t<div class=\"clear\"><img src=\"";
        // line 288
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/pixel.gif\" /></div>
\t</div><!--/content_block-->
</div><!--/body-->

\t\t<!--\t<div class=\"banner_right\">
<a href=\"https://www.kse.kg\" target='_blank' >
<img src=\"";
        // line 294
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/1.jpg\" border=\"0\"/></a>
</div> -->

<div class=\"clear\"><img src=\"";
        // line 297
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/pixel.gif\" /></div>
<div id=\"footer\">
\t<div class=\"footer_content\">
\t\t<div class=\"footer_inner\">
\t\t
\t\t\t<div class=\"footer_left\">
\t\t\t\t
\t\t\t\t<p class=\"footer\">ЗАО \"Кыргызская Фондовая Биржа\"</p>
                                <p>720010 Кыргызская Республика, <br />г. Бишкек, ул. Московская, 172, +996 312 31 14 84, +996 551 31 14 84</p>
\t\t\t\t<p class=\"footer\">Электронная почта: <a href=\"mailto:office@kse.kg\" class=\"mail\">office@kse.kg</a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
\t\t\t\t\t\t
\t\t\t\t
\t\t\t\t\t\t\t\t<!-- WWW.NET.KG , code for www.kse.kg -->
<script language=\"javascript\" type=\"text/javascript\">
 java=\"1.0\";
 java1=\"\"+\"refer=\"+escape(document.referrer)+\"&amp;page=\"+escape(window.location.href);
 document.cookie=\"astratop=1; path=/\";
 java1+=\"&amp;c=\"+(document.cookie?\"yes\":\"now\");
</script>
<script language=\"javascript1.1\" type=\"text/javascript\">
 java=\"1.1\";
 java1+=\"&amp;java=\"+(navigator.javaEnabled()?\"yes\":\"now\");
</script>
<script language=\"javascript1.2\" type=\"text/javascript\">
 java=\"1.2\";
 java1+=\"&amp;razresh=\"+screen.width+'x'+screen.height+\"&amp;cvet=\"+
 (((navigator.appName.substring(0,3)==\"Mic\"))?
 screen.colorDepth:screen.pixelDepth);
</script>
<script language=\"javascript1.3\" type=\"text/javascript\">java=\"1.3\"</script>
<script language=\"javascript\" type=\"text/javascript\">
 java1+=\"&amp;jscript=\"+java+\"&amp;rand=\"+Math.random();
 document.write(\"<a href='https://www.net.kg/stat.php?id=622&amp;fromsite=622' target='_blank'>\"+
 \"<img src='https://www.net.kg/img.php?id=622&amp;\"+java1+
 \"' border='0' alt='WWW.NET.KG' width='21' height='16' /></a>\");
</script>
<noscript>
 <a href='https://www.net.kg/stat.php?id=622&amp;fromsite=622' target='_blank'><img
  src=\"https://www.net.kg/img.php?id=622\" border='0' alt='WWW.NET.KG' width='21'
  height='16' /></a>
</noscript>
<!-- /WWW.NET.KG -->\t
<a href=\"https://www.kse.kg/views/kse/templates/modules/Rss/rss.php\" target=\"_blank\">Rss новости</a>
<br><br>\t\t
\t\t\t\t</p>
\t\t\t\t
\t</div><!--/footer_left-->
\t\t\t  <div class=\"footer_right\">
                            <p class=\"footer\">Все права защищены © 2004-2022</p>
\t\t\t\t\t\t\t<p class=\"footer\">Копирование материалов – только с письменного разрешения.</p>
\t\t\t\t<p class=\"footer\">Лицензия №37 НКРЦБ от 30.11.2000 г.</p>
\t\t\t\t<!--<a href=\"#\" class=\"counter\">&nbsp;</a>-->
\t\t\t</div><!--/footer_right-->
\t\t</div><!--/footer_inner-->
\t\t<br><br><br><br><br>
\t<!--\t\t <div class=\"banner\">
\t\t\t
\t\t\t<a href=\"http://www.fkb.kg\" target='_blank' ><img src=\"";
        // line 354
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/fkb.gif\" border=\"0\"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
\t\t\t<a href=\"http://www.bankkg.kg\" target='_blank' ><img src=\"";
        // line 355
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/kbkr.gif\" border=\"0\"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
\t\t\t\t<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\"120\" height=\"60\">
        <param name=\"movie\" value=\"";
        // line 357
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/120-60.swf\" />
        <object type=\"application/x-shockwave-flash\" data=\"";
        // line 358
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/120-60.swf\" width=\"120\" height=\"60\">
        </object>
      </object>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
\t\t\t<a href=\"http://press.kse.kg\" target='_blank' ><img src=\"";
        // line 361
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/views/kse/images/ban1.jpg\" border=\"0\"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

\t\t\t</div>\t -->
\t\t\t

\t\t\t
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
