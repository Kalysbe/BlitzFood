<?php

// TODO: Totally remake this module

if (isset($_POST["doAddEntry"])) {
    require_once("../../config.inc.php");
    require_once("../../mainfile.php");

    $blog_id = $_POST["BlogId"];
    $text = $_POST["mEntryText"];
    $title = $_POST["mEntryName"];
    $title_en = strtr($title, $Translit);
    if (trim($_POST["mEntryDate"]) == "")
        $date = date("Y-m-d H:i:s");
    else
        $date = $_POST["mEntryDate"];

    $sql = "INSERT INTO `Blog_Entries` (`blog_id`, `name`, `title`, `text`, `cr_date`, `status`) VALUES (
        '" . $blog_id . "',
        '" . $title_en . "',
        '" . $title . "',
        '" . $text . "',
        '" . $date . "',
        '1'
    )";
    mysql_query($sql);
    $id = mysql_insert_id();

    $sql = "SELECT * FROM `Blogs` WHERE (`blog_id`='" . $blog_id . "')";
    $result = mysql_query($sql);
    $rows = mysql_num_rows($result);
    $obj = mysql_fetch_object($result);

    Header ("Location: " . MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" . 
            $_POST["cur_lang"] . "/" . $obj->blog_name . "/" . $id . "/" . $title_en);
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

    $blog_id = $_POST["blog_id"];
    $blogentry_id = $_POST["blogentry_id"];
    $text = $_POST["text"];
    $title = $_POST["title"];
    $title_en = strtr($title, $Translit);
    if (trim($_POST["cr_date"]) == "")
        $cr_date = date("Y-m-d H:i:s");
    else
        $cr_date = $_POST["cr_date"];

    $sql = "UPDATE `Blog_Entries` SET
        `name`='" . $title_en . "',
        `title`='" . $title . "',
        `text`='" . $text . "',
        `cr_date`='" . $cr_date . "'
        WHERE (`blogentry_id`='" . $blogentry_id . "')
    ";
    mysql_query($sql);
    if (mysql_error() != "") {
        MainClass::getSingleton()->appendError(mysql_error());
    }
}

// Load existing data for this blog

if (isset($Blog)) {

    // Getting pages list from current blog
    $start_position = 0;
    $num = 20;
    $route = MainClass::getSingleton()->getFullUriPath();
    if (count($route) >= 5) {
        if (($route[4] != "")&&(is_numeric(intval($route[4])))&&(intval($route[4]) != 0)) {
            $start_position = $route[4] * $num - $num;
        } elseif (($route[4] != "")&&($route[4] == "Edit")) {
            $Controller->appendVariable("edit_form", true);
            $post_sql = "SELECT * FROM `Blog_Entries_eng` WHERE (`blogentry_id`='" . $route[5] . "')";
            $post_result = mysql_query($post_sql);
            $post_rows = mysql_num_rows($post_result);
            if ($post_rows == 1) {
                $edit_post = mysql_fetch_object($post_result);
                $post['name'] = $edit_post->title;
                $post['blogentry_id'] = $edit_post->blogentry_id;
                $post['text'] = $edit_post->text;
                $post['cr_date'] = $edit_post->cr_date;
                $Controller->appendVariable('edit_post', $post);
            }
        }
    }


    $__sql = "SELECT COUNT(*) AS `amount` FROM `Blog_Entries_eng`
        WHERE (`blog_id`='" . $Blog->get_blog_id() . "')";
    $__result = mysql_query($__sql);
    $amount = mysql_fetch_object($__result);
    $pages_array = array();
    for ($i = 1; $i <= $amount->amount / 10; $i++) {
        $pages_array[$i] = $i;
    }
    $Controller->appendVariable("pages_list", $pages_array);

    $__sql = "SELECT `blogentry_id`,`name`,`title`,
        `cr_date` FROM `Blog_Entries`
        WHERE (`blog_id`='" . $Blog->get_blog_id() . "') ORDER BY `cr_date` DESC LIMIT " . $start_position . "," . $num;
    $__result = mysql_query($__sql);
    
    $__rows = mysql_num_rows($__result);
    $__Entries = array();
    for ($__i = 0; $__i < $__rows; $__i++) {
        mysql_data_seek($__result, $__i);
        $e = mysql_fetch_object($__result);
        $__Entries[$__i]["Id"] = $e->blogentry_id;
        $__Entries[$__i]["Name"] = $e->name;
        $__Entries[$__i]["Title"] = $e->title;
        $__Entries[$__i]["Date"] = $e->cr_date;
    }
    $Controller->appendVariable("Posts", $__Entries);
}

?>
