<?php
define('__ROOT__', dirname(dirname(dirname(__FILE__))));
require_once(__ROOT__ . '/config.inc.php');
require_once(__ROOT__ . '/mainfile.php');

$link = MainClass::getSingleton()->getDbConnection();


    $sql = "SELECT * FROM `mod_quotes` WHERE buy_amount * buy_price > 1000 OR sell_amount * sell_price > 1000";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    $message = '';
for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
        $v = $obj->full_name;
        if ($obj->buy_amount != 0) {
            $message .= "<b>Покупка: </b> $v \n<b>Количество: </b> <i>" . $obj->buy_amount . "</i>\n<b>Цена: </b> <i>" . $obj->buy_price . " </i> <b>\n\n";
        }
        if ($obj->sell_amount != 0) {
            $q["sell_amount"] = $obj->sell_amount;
            $message .= "<b>Продажа: </b> $v \n<b>Количество</b> <i>" . $obj->sell_amount . "</i>\n<b>Цена</b> <i>" . $obj->sell_price . " </i>\n\n";
        }
        

    }

    var_dump( $message);
define('TELEGRAM_TOKEN', '1189195605:AAHqZRiDWdzaldugY7cHLtYod_aPhsa51KU');

// сюда нужно вписать ваш внутренний айдишник
define('TELEGRAM_CHATID', '842943308');



function message_to_telegram($text)
{
    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => array(
                'chat_id' => TELEGRAM_CHATID,
                'text' => $text,
                'parse_mode' => 'HTML'
            ),
        )
    );
    curl_exec($ch);
	echo 1;
}
message_to_telegram($message);

?>