<?php 

// описание метода api telegram 
// https://core.telegram.org/bots/api#sendmessage
 
$tg_user = '-1001617454030'; // id пользователя, которому отправиться сообщения
$bot_token = '5594277396:AAG-xgarArGLtfbfHXhJ6tvnCl5AyaeDJ18'; // токен бота
$name = 'ОАО "Полибетон" : Изменение в списке владельцев ценных бумаг (физических лиц)';
$text = "<b>$name</b> \n \n <a href=\"https://www.kse.kg/ru/RussianAllNewsBlog/7401/OAO\">Источник Кыргызская Фондовая Биржа</a> \n 21-06-2022";

 
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
 
var_dump(json_decode($result));

?>