<?php
 $domOBJ = new DOMDocument();
 $domOBJ->load("https://www.kse.kg/views/kse/templates/modules/Rss/rss.php");//XML page URL
 
 $content = $domOBJ->getElementsByTagName("item");
 
 foreach( $content as $data )
 {
   $title = $data->getElementsByTagName("title")->item(0)->nodeValue; 
   echo "<br>";
   $link = $data->getElementsByTagName("link")->item(0)->nodeValue;
   echo "$title :: $link";
 }
?>