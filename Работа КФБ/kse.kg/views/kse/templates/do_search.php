<?php
//�������� ������ ����� $_POST
if (isset($_GET['search'])) {
    // ������������ � ����
    include('db.php');
    $db = new db();
    // ������� �� ��������� �������� ������! ���������� ��!
    $word = mysql_real_escape_string($_GET['search']);
    // ������ ������
    $sql = "SELECT * FROM Blog_Entries WHERE title LIKE '%" . $word . "%' ORDER BY title LIMIT 30";
    // �������� ����������
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
        echo '<li>По вашему запросу ничего не найдено</li>';
    }
}
?>
