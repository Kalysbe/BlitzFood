<?php

require_once( './config.inc.php' );	

//$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"] );

function getPrevRate($currency, $max_date) {
	$link = MainClass::getSingleton()->getDbConnection();
    $result = mysqli_query($link, "SELECT `rate` FROM `mod_currency` WHERE (`date`<'" .
            $max_date . "' AND `currency`='" . $currency . "') ORDER BY `date` DESC LIMIT 1");
    $rows = $result->num_rows;
    if ($rows == 0)
        return -1;
    $obj = mysqli_fetch_object($result);
    return $obj->rate;
}

function Currency_getModuleBuffer($id) {
	$link = MainClass::getSingleton()->getDbConnection();
    $today = date("Y-m-d");
    $sql = "SELECT MAX(`date`) as `date` FROM `mod_currency`";
    $result = mysqli_query($link, $sql);
    $max_date = mysqli_fetch_object($result);
    $sql = "SELECT * FROM `mod_currency` WHERE (`date`='" . $max_date->date . "') /*GROUP BY `currency`*/";
    $result = mysqli_query($link, $sql);
    $rows = $result->num_rows;

    $display_date = date("d-m-Y", strtotime($max_date->date));

    $buffer = "
		<h2>currency:</h2>
        <table class=\"class2\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
        <tr>
            <th colspan=\"3\">registration " . $display_date . "</th>
        </tr>
    ";

    for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);


        $image = "<img src=\"/views/kse/images/pixel.gif\" width=\"5px\" /> ";
        $prevRate = getPrevRate($obj->currency, $max_date->date);
        if ($prevRate != -1) {
            if ($obj->rate < $prevRate) {
                $image = "<font color=\"red\">&#9660;</font> ";
            } elseif ($obj->rate > $prevRate) {
                $image = "<font color=\"green\">&#9650;</font> ";
            }
        }

        $buffer.= "
            <tr>
                    <td width=\"23\"><img src=\"/views/kse/images/" . $obj->flag . "\" alt=\"" . $obj->currency . "\"/></td>
                    <td width=\"120\">" . $obj->currency_name . "</td>
                    <td width=\"*\">" . $image . $obj->rate . "</td>
            </tr>
        ";
    }

    $buffer.= "</table>";
    return $buffer;
}

?>