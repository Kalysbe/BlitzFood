<?php

/* modules/Blog/Entry.html */
class __TwigTemplate_ea64bde1d195f86e8232201d849b855b extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<style type=\"text/css\">
\t/*lightbox*/
        
        .lightbox {
          display: none;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.7);
          position: fixed;
          top: 0;
          left: 0;
          z-index: 20;
          padding-top: 5%;
          box-sizing: border-box;
        }
        
        .lightbox img {
          display: block;
          margin: auto;
          max-width: 80%;
        }
        
        .lightbox .caption {
          margin: 15px auto;
          width: 50%;
          text-align: center;
          font-size: 1em;
          line-height: 1.5;
          font-weight: 700;
          color: #eee;
        }

        .grid {
          overflow: hidden;
          display: inline-block;
          vertical-align: top;
        }

        .grid img {
          transition: all 0.3s;
        }

        .grid img:hover {
          cursor: pointer;
          transform: scale(1.1);
        }
        
        .center_big table tbody tr {
          vertical-align: top;
          text-align: left;
        }
        /*lightbox*/
</style>

<h3>";
        // line 55
        echo (isset($context['EntryTitle']) ? $context['EntryTitle'] : null);
        echo "</h3>
<br><br>
<p>";
        // line 57
        echo (isset($context['EntryText']) ? $context['EntryText'] : null);
        echo "</p>

";
        // line 59
        if ($this->getAttribute((isset($context['LoggedUser']) ? $context['LoggedUser'] : null), "getUsername", array(), "any") == "admin") {
            echo "
  <a href=\"http://www.kse.kg/ru/RussianAllNewsBlog/ControlPanel/Edit/";
            // line 60
            echo (isset($context['blog_id']) ? $context['blog_id'] : null);
            echo "\">Редактировать новость</a>
";
        }
        // line 61
        echo "

<script type=\"text/javascript\">

  \$(\"p img\").wrap(\"<div class='grid'></div>\");
\t// Create a lightbox
    (function() {
      var \$lightbox = \$(\"<div class='lightbox'></div>\");
      var \$img = \$(\"<img>\");
      var \$caption = \$(\"<p class='caption'></p>\");
    
      // Add image and caption to lightbox
    
      \$lightbox
        .append(\$img)
        .append(\$caption);
    
      // Add lighbox to document
    
      \$('body').append(\$lightbox);
    
      \$('.grid img').click(function(e) {
        e.preventDefault();
    
        // Get image link and description
        var src = \$(this).attr(\"src\");
        var cap = \$(this).attr(\"alt\");
    
        // Add data to lighbox
    
        \$img.attr('src', src);
        \$caption.text(cap);
    
        // Show lightbox
    
        \$lightbox.fadeIn('fast');
    
        \$lightbox.click(function() {
          \$lightbox.fadeOut('fast');
        });
      });
    
    }());

</script>";
    }

}
