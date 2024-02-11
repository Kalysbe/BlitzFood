<?php

// TODO: Totally remake this module
define('__ROOT__', dirname(dirname(dirname(__FILE__)))); 
require_once(__ROOT__.'/config.inc.php');
require_once(__ROOT__.'/mainfile.php');


if (isset($_POST["doAddEntry"])) {

	$link_mysql = MainClass::getSingleton()->getDbConnection();
	
	//$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"] );
	
    $blog_id = $_POST["BlogId"];
    $text = $_POST["mEntryText"];
    $title = $_POST["mEntryName"];
    $title_en = strtr($title, $Translit);
	$link = $_POST["mEntryCompany"];
    if (trim($_POST["mEntryDate"]) == "")
        $date = date("Y-m-d H:i:s");
    else
        $date = $_POST["mEntryDate"];

    $sql = "INSERT INTO `Blog_Entries` (`blog_id`, `name`, `title`, `text`, `cr_date`, `link_company_id`, `status`) VALUES (
        '" . $blog_id . "',
        '" . $title_en . "',
        '" . $title . "',
        '" . $text . "',
        '" . $date . "',
		'" . $link . "',
        '1'
    )";
    
	
	
	mysqli_query($link_mysql, $sql);
    $id = mysqli_insert_id( $link_mysql );

    $sql = "SELECT * FROM `Blogs` WHERE (`blog_id`='" . $blog_id . "')";
    $result = mysqli_query($link_mysql, $sql);
    $rows = mysqli_num_rows($result);
    $obj = mysqli_fetch_object($result);
    $lang = $_POST["cur_lang"];
    $blog_name = $obj->blog_name;
    Header ("Location: " . MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" . 
            $lang . "/" . $blog_name . "/" . $id . "/" . $title_en);

    $tg_user = '-1001388507564'; // id пользователя, которому отправиться сообщения
    $bot_token = '5594277396:AAG-xgarArGLtfbfHXhJ6tvnCl5AyaeDJ18'; // токен бота
    $text = "<b>$title</b> \n \n <a href=\"https://www.kse.kg/$lang/$blog_name/$id\">Источник: Кыргызская Фондовая Биржа</a> \n $date";

     
    // параметры, которые отправятся в api телеграмм
    $params = array(
        'chat_id' => $tg_user, // id получателя сообщения
        'text' => $text, // текст сообщения
        'parse_mode' => 'HTML', // режим отображения сообщения, не обязательный параметр
    );
     
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . $bot_token . '/sendMessage'); // адрес api телеграмм
    curl_setopt($curl, CURLOPT_POST, true); // отправка данных методом POST
    curl_setopt($curl, CURLOPT_TIMEOUT, 10); // максимальное время выполнения запроса
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params); // параметры запроса
    $result = curl_exec($curl); // запрос к api
    curl_close($curl);
    exit;
} else if (isset($_POST["do_edit_entry"])) {
	
    $Translit = array(
        "Ґ"=>"G","Ё"=>"YO","Є"=>"E","Ї"=>"YI","І"=>"I",
        "і"=>"i","ґ"=>"g","ё"=>"yo","№"=>"#","є"=>"e",
        "ї"=>"yi","А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
        "Д"=>"D","Е"=>"E","Ж"=>"ZH","З"=>"Z","И"=>"I",
        "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
        "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
        "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
        "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"'","Ы"=>"YI","Ь"=>"",
        "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"zh",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"",
        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
    );

    $link_mysql = MainClass::getSingleton()->getDbConnection();
	
	$blog_id = $_POST["blog_id"];
    $blogentry_id = $_POST["blogentry_id"];
    $text = $_POST["text"];
    $title = $_POST["title"];
	$link = $_POST["mEntryCompany"];
    $title_en = strtr($title, $Translit);
    if (trim($_POST["cr_date"]) == "")
        $cr_date = date("Y-m-d H:i:s");
    else
        $cr_date = $_POST["cr_date"];

    $sql = "UPDATE `Blog_Entries` SET
        `name`='" . $title_en . "',
        `title`='" . $title . "',
        `text`='" . $text . "',
        `cr_date`='" . $cr_date . "',
		`link_company_id`='" . $link . "'
        WHERE (`blogentry_id`='" . $blogentry_id . "')
    ";
    $link = MainClass::getSingleton()->getDbConnection();
	mysqli_query($link_mysql, $sql);
    if (mysqli_error($link_mysql) != "") {
        MainClass::getSingleton()->appendError(mysqli_error($link_mysql));
    }
}

// Load existing data for this blog

if (isset($Blog)) {

	$link = MainClass::getSingleton()->getDbConnection();
    // Getting pages list from current blog
    $start_position = 0;
    $num = 20;
    $route = MainClass::getSingleton()->getFullUriPath();

    if (count($route) >= 5) {
        if (($route[4] != "")&&(is_numeric(intval($route[4])))&&(intval($route[4]) != 0)) {
            $start_position = $route[4] * $num - $num;
        } elseif (($route[4] != "")&&($route[4] == "Edit")) {
            $Controller->appendVariable("edit_form", true);
            $post_sql = "SELECT * FROM `Blog_Entries` WHERE (`blogentry_id`='" . $route[5] . "')";
            $post_result = mysqli_query($link, $post_sql);
            $post_rows = mysqli_num_rows($post_result);
            if ($post_rows == 1) {
                $edit_post = mysqli_fetch_object($post_result);
                $post['name'] = $edit_post->title;
                $post['blogentry_id'] = $edit_post->blogentry_id;
                $post['text'] = $edit_post->text;
                $post['cr_date'] = $edit_post->cr_date;
				$post['l_company_id'] = $edit_post->link_company_id;
                $Controller->appendVariable('edit_post', $post);
            }
		} elseif (($route[4] != "")&&($route[4] == "Delete")) {
			$post_sql = "delete FROM `Blog_Entries` WHERE (`blogentry_id`='" . $route[5] . "')";
            $post_result = mysqli_query($link, $post_sql);
		}	
    }


    $__sql = "SELECT COUNT(*) AS `amount` FROM `Blog_Entries`
        WHERE (`blog_id`='" . $Blog->get_blog_id() . "')";
    $__result = mysqli_query($link, $__sql);
    $amount = mysqli_fetch_object($__result);
    $pages_array = array();
    for ($i = 1; $i <= $amount->amount / 10; $i++) {
        $pages_array[$i] = $i;
    }
    $Controller->appendVariable("pages_list", $pages_array);

    $__sql = "SELECT `blogentry_id`,`name`,`title`,
        `cr_date` FROM `Blog_Entries`
        WHERE (`blog_id`='" . $Blog->get_blog_id() . "') ORDER BY `cr_date` DESC LIMIT " . $start_position . "," . $num;
    $__result = mysqli_query($link, $__sql);
    
    $__rows = mysqli_num_rows($__result);
    $__Entries = array();
    for ($__i = 0; $__i < $__rows; $__i++) {
        mysqli_data_seek($__result, $__i);
        $e = mysqli_fetch_object($__result);
        $__Entries[$__i]["Id"] = $e->blogentry_id;
        $__Entries[$__i]["Name"] = $e->name;
        $__Entries[$__i]["Title"] = $e->title;
        $__Entries[$__i]["Date"] = $e->cr_date;
    }
    $Controller->appendVariable("Posts", $__Entries);
	
    $__sql_sprCompany = "SELECT `brep_company_id`,`title` FROM `brep_companies` ORDER BY `title` ASC";
    $__result_sprCompany = mysqli_query($link, $__sql_sprCompany);
    
    $__rows = mysqli_num_rows($__result_sprCompany);
    $__Entries2 = array();
    for ($__i = 0; $__i < $__rows; $__i++) {
        mysqli_data_seek($__result_sprCompany, $__i);
        $ee = mysqli_fetch_object($__result_sprCompany);
        $__Entries2[$__i]["company_id"] = $ee->brep_company_id;
        $__Entries2[$__i]["title"] = $ee->title;
    }
    $Controller->appendVariable("sprCompanys", $__Entries2);	
}

?>
