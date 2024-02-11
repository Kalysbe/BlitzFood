<?php

// TODO: Totally remake this module
define('__ROOT__', dirname(dirname(dirname(__FILE__))));
require_once(__ROOT__ . '/config.inc.php');
require_once(__ROOT__ . '/mainfile.php');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


// Парсинг json от oi.kse
$inputJson = file_get_contents('php://input');
$input = json_decode($inputJson, true);

$link_mysql = MainClass::getSingleton()->getDbConnection();
//Поиск компании по имени, если есть то, возвращаем id этой компании
$str = str_replace('"', '', $input["mEntryCompany"]); // Имя компании, убираем ковычки
$str = trim($str); // убираем пробелы из начала и конца если они есть
$obj = 0;
if ($input["idCompany"] == 0) {
	$sql = 'SELECT brep_company_id FROM brep_companies WHERE title LIKE \'' . $str . '%\'';
	$result = mysqli_query($link_mysql, $sql);
	$rows = mysqli_num_rows($result);
	$obj = mysqli_fetch_object($result);
} else {
	$obj = (object) array (
		'brep_company_id' => $input["idCompany"]
	);
}

if ($obj->brep_company_id != 0) { // При условии что id найден
    $Translit = array(
        "Ґ" => "G", "Ё" => "YO", "Є" => "E", "Ї" => "YI", "І" => "I",
        "і" => "i", "ґ" => "g", "ё" => "yo", "№" => "#", "є" => "e",
        "ї" => "yi", "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
        "Д" => "D", "Е" => "E", "Ж" => "ZH", "З" => "Z", "И" => "I",
        "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
        "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
        "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
        "Ш" => "SH", "Щ" => "SCH", "Ъ" => "'", "Ы" => "YI", "Ь" => "",
        "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
        "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "zh",
        "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
        "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
        "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
        "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "",
        "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
    );



    $table = '<table><tbody role="rowgroup">';

    $n = 0;
    foreach($input['title']['titles'] as $i=>$value){
        $value = str_replace(array("\r\n", "\r", "\n"), '<br>', $value);
        if(is_array($value) && $value['type'] == 'date'){
            $table .= '<tr><td width="40%">' . $value['text'] . '</td><td>' . $input['mEntryText'][$n] . '</td></tr>';
            $n++;
        }
        else if (is_array($value) && $value['type'] == 'header'){
            $table .= '<tr><td colspan="2"><h5>' . $value['text'] .'</h5></td></tr>';
        }
        else {
            $table .= '<tr><td width="40%">' . $value . '</td><td>' . $input['mEntryText'][$n] . '</td></tr>'; 
            $n++;
        }
        
    };

    $table .= '</tbody></table>';



    $blog_id =      $input["BlogId"];               // blog_id
    $text =         $table;                         // text
    $title =        $input["mEntryName"];           // title
    $title_en =     strtr($title, $Translit);       // name
    $link =         $obj->brep_company_id;          // link_company_id
    $date =         date("Y-m-d H:i:s");

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
    $id = mysqli_insert_id($link_mysql);

    echo $id;

    // if ($id) {
    //     $tg_user = '-1001388507564'; // id пользователя, которому отправиться сообщения
    //     $bot_token = '5594277396:AAG-xgarArGLtfbfHXhJ6tvnCl5AyaeDJ18'; // токен бота
    //     $text = "<b>$title</b> \n \n <a href=\"https://www.kse.kg/ru/RussianAllNewsBlog/$id\">Источник: Кыргызская Фондовая Биржа</a> \n $date";

         
    //     // параметры, которые отправятся в api телеграмм
    //     $params = array(
    //         'chat_id' => $tg_user, // id получателя сообщения
    //         'text' => $text, // текст сообщения
    //         'parse_mode' => 'HTML', // режим отображения сообщения, не обязательный параметр
    //     );
         
    //     $curl = curl_init();
    //     curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . $bot_token . '/sendMessage'); // адрес api телеграмм
    //     curl_setopt($curl, CURLOPT_POST, true); // отправка данных методом POST
    //     curl_setopt($curl, CURLOPT_TIMEOUT, 10); // максимальное время выполнения запроса
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $params); // параметры запроса
    //     $result = curl_exec($curl); // запрос к api
    //     curl_close($curl);
    // }

   //print_r($input);
    exit;
}


exit;
