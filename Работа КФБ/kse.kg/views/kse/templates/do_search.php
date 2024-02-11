<?php
//получаем данные через $_POST
if (isset($_GET['search'])) {
    // подключаемся к базе
    include('db.php');
    $db = new db();
    // никогда не доверяйте входящим данным! Фильтруйте всё!
    $word = mysql_real_escape_string($_GET['search']);
    // Строим запрос
    $sql = "SELECT * FROM Blog_Entries WHERE title LIKE '%" . $word . "%' ORDER BY title LIMIT 30";
    // Получаем результаты
    $row = $db->select_list($sql);
    if(count($row)) {
        $end_result = '';
        foreach($row as $r) {
			$result         = $r['title'];
			//$date           = $r['cr_date'];
            $bold           = '<span class="found">' . $word . '</span>';
            //$end_result     .= '<li>' . str_ireplace($word, $bold, $result) . '</li>';
			$end_result     .= '<li><a href="http://www.kse.kg/ru/RussianAllNewsBlog/'.$r['blogentry_id'].'">' . str_ireplace($word, $bold, $result) . '</a></li>';
        }
       echo $end_result;
	   //echo iconv("UTF-8", "windows-1251", $end_result);
    } else {
        echo '<li>РџРѕ РІР°С€РµРјСѓ Р·Р°РїСЂРѕСЃСѓ РЅРёС‡РµРіРѕ РЅРµ РЅР°Р№РґРµРЅРѕ</li>';
    }
}
?>
