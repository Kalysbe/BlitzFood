<?php

// Create connection
 $mysqli = new mysqli("localhost", "ksedbadmin", "kbyerc2010", "kse");
// Check connection
if ($mysqli->connect_errno) {
    printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
    exit();
} 

// Новости в RSS
 $result = $mysqli->query("SELECT * FROM Blog_Entries WHERE blog_id=3 ORDER BY cr_date DESC LIMIT 10");
 $rows = $result->num_rows;
// --------------------------------------


//--------------------------------------------

 header( "Content-type: text/xml");




 // Вывод RSS




 echo "<?xml version='1.0' encoding='UTF-8'?>
 <rss version='2.0'>
 <channel>
<title>Кыргызская Фондовая Биржа </title>
 <link>https://www.kse.kg</link>
 <description>rss.kse.kg</description>
 <language>ru</language>


 ";


 for ($i = 0; $i < $rows; $i++) {
    $rss_obj=mysqli_fetch_object($result);
    $id = $rss_obj->blogentry_id;
    $title =  $rss_obj->title;
    // удаление всех html тегов из текста
    // $text = strip_tags($rss_obj->text);
    $date =$rss_obj->cr_date;




 

    $text = date_format( date_create($date), 'd-m-Y');
    $name =  $rss_obj->name;
    // поиск элементов массива в строке и замена на пустоту
    // $text = str_ireplace( array('&nbsp;', '&raquo;', '&laquo;', '&ndash;', '&quot;' ),'', $text); 

   echo "<item>

   <title>$title</title>
   <link>https://www.kse.kg/ru/RussianAllNewsBlog/$id</link>
   <guid>https://www.kse.kg/ru/RussianAllNewsBlog/$id</guid>
   <description>$text</description>
   <pubDate>$date</pubDate>
   </item>";
 }
 echo "</channel></rss>";

 $result->close();
  $mysqli->close();

?>