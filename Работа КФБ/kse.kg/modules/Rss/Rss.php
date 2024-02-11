<?php

$Module = "Rss";

function Rss_loadController() {
 $Controller = new ControllerClass();
 $Uri = MainClass::getSingleton()->getFullUriPath();
  $link = MainClass::getSingleton()->getDbConnection();
  
  $Controller->appendVariable("ControllerInclusion", "modules/Rss/Rss.html");


  $sql = "SELECT * FROM Blog_Entries";

  $result = mysqli_query($link, $sql);
  $rows = mysqli_num_rows($result);
  for ($i = 0; $i < $rows; $i++) {
            //smysqli_data_seek($result, $i);
    $rss_obj=mysqli_fetch_object($result);
    $RssArray[$i]['id'] = $rss_obj->id;
    $RssArray[$i]['title'] =  $rss_obj->title;
    $RssArray[$i]['text'] = $rss_obj->text;
    $RssArray[$i]['date'] =  $rss_obj->date;
    $RssArray[$i]['kse'] =  $rss_obj->kse;
  }
  print_r($RssArray);
  $Controller->appendVariable("RssArray", $RssArray);

   /* echo '<?xml version="1.0"?>
          <rss version="2.0">
          <channel>
          <title>Название RSS-канала</title>
          <link>http://www.kse.kg</link>
          <description>Описание канала (кратко)</description>';
   
     echo '<item>
            <title>$title</title>
            <link>http://www.kse.kg/ru/RussianAllNewsBlog/$id/$title</link>
            <description>$text</description>
            <author>$author</author>
            <pubDate>$date</pubDate>
            <guid>http://www.kse.kg/ru/RussianAllNewsBlog/$id/$title</guid>
         </item>';
   }     
   echo '</channel>
   </rss>';   */
   return $Controller;
}

?>