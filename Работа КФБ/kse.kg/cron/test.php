<?php
/*
 * This script is to update currency
 */
require_once("../config.inc.php");

$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"] );

/*$query = "
	select * from
	(
		select tc.shortname as name, tc.namerus, tc.extcode as quotes, ts.makedate(tc.zakdate),(case when ts.makedate(tc.zakdate) like '-' then '' else concat(', дата закрытия ',to_char(ts.makedate(tc.zakdate))) end) as dt,
		       (select (max(to_number(ts.makeb(www.dot(round(price,4)), direct))))
		              from ts.orders t where t.ownid=tc.ords_id) as b,
			             (select sum(volume)
				            from ts.orders t where t.ownid=tc.ords_id
					           and t.price=(select max(to_number(ts.makeb(price, direct))) from ts.orders t where t.ownid=tc.ords_id)
						          ) as bv,
							         (select (min(to_number(ts.makes(www.dot(round(price,4)), direct))))
								        from ts.orders t where t.ownid=tc.ords_id) as s,
									       (select sum(volrest)
									              from ts.orders t where t.ownid=tc.ords_id
										             and t.price=(select min(to_number(ts.makes(price, direct))) from ts.orders t where t.ownid=tc.ords_id)
											            ) as sv
												      from ts.ts_currinstrument_arcts tc
												       )
												        where b is not null or s is not null
";*/

$query = "
SELECT F11G.namerus, F11G.volrest, ts.makeb(round(price,4),direct) AS b,
ts.makes(round(price,4),direct) AS s, ts.makedate(F11G.date0) as date_, ts.makedate(F11G.date0) || ',  ' || ts.maketime(F11G.time) as date_full
FROM ts.orders_curr F11G
order by date0
";
// ts.makedate(F11G.date0) || ',  ' || ts.maketime(F11G.time) as date_
$conn = oci_connect($_DB["ORA_USER"], $_DB["ORA_PASS"], $_DB["ORA_CSTRING"], $_DB["ORA_CHARSET"]);
if (!$conn) {
	$e = oci_error();
	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	exit();
}

$stid = oci_parse($conn, $query);
if (!$stid) {
	$e = oci_error($conn);
	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	exit();
}

// Perform the logic of the query
$r = oci_execute($stid);
if (!$r) {
	$e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	exit();
}

function FormatNum($num)
{
	if (strlen($num) < 2)
	return '0'.$num;
	else return $num;
}

$message = "В ТС ЗАО \"КФБ\" поступила новая заявка: \n";
$date = date("d/m/Y", mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')));
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {

	

    foreach ($row as $k=>$v) {
        if ($k == 'NAMERUS' and $row['DATE_'] == $date) {
			$full_date = $row['DATE_FULL'];
			$v = mb_convert_encoding($v, "Windows-1251", "UTF-8");
			if ($row["B"] != null)
				$message .= "<b>Покупка</b> | $v  | <b>Количество</b>" . $row["VOLREST"] . " | <b>Цена</b> " . $row["B"] . " | <b>Дата</b> $full_date\n\n";
			else
				$message .= "<b>Продажа</b> | $v  | <b>Количество</b> <i>" . $row["VOLREST"] . "</i> | <b>Цена</b> <i>" . $row["S"] . " </i>| <b>Дата</b> $full_date\n\n";
		}
	}
	

    //BV - count
    //B  - price

}



	//$token = '1189195605:AAHqZRiDWdzaldugY7cHLtYod_aPhsa51KU';
   // $sendToTelega = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id=306578251&parse_mode=html&text={$message}", "r");
   
   
   // сюда нужно вписать токен вашего бота
define('TELEGRAM_TOKEN', '1189195605:AAHqZRiDWdzaldugY7cHLtYod_aPhsa51KU');

// сюда нужно вписать ваш внутренний айдишник
define('TELEGRAM_CHATID', '306578251');



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
            ),
        )
    );
    curl_exec($ch);
	echo 1;
}
message_to_telegram('Привет!');
    
//   $PushMeBot_key='bba820e0c7bac8e2469d3a3e92a1878b';
  
//    if($ch = curl_init()) {
// 	  curl_setopt($ch, CURLOPT_URL, 'http://pushmebot.ru/send 
// 	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 	  curl_setopt($ch, CURLOPT_POSTFIELDS, 'key='.$PushMeBot_key.'&message='.$message);
// 	  $out = curl_exec($ch);
// 	  curl_close($ch);
// 	}
// 	else {
// 		echo $message;
// 	}


/*

'" . $row["NAME"] . "',
					'" . $row["QUOTES"] . "',
					'" . mb_convert_encoding($row["NAMERUS"], 
						"UTF-8", "Windows-1251") . "',
					'" . $row["BV"] . "',
					'" . $row["B"] . "',
					'" . $row["SV"] . "',
					'" . $row["S"] . "'

*/

?>
