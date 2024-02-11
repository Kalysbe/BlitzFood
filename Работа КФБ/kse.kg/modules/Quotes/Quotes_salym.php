<?php


$Module = "Quotes_Salym";

function Quotes_Salym_loadController() {
	$link = MainClass::getSingleton()->getDbConnection();
    $Controller = new ControllerClass();
    $Uri = MainClass::getSingleton()->getFullUriPath();

    $Controller->appendVariable("ControllerInclusion", "modules/Quotes/Quotes_Salym.html");

    $sql = "SELECT * FROM `mod_quotes_salym`";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    $Quotes = array();
    for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
        $q["short_name"] = $obj->short_name;
        $q["full_name"] = $obj->full_name;
        if ($obj->buy_amount != 0)
            $q["buy_amount"] = $obj->buy_amount;
        else
            $q["buy_amount"] = "";
        $q["buy_price"] = $obj->buy_price;
        $q["date1"] = $obj->date1;
        $q["time1"] = $obj->time1;
        $Quotes[] = $q;
    }

    $Controller->appendVariable("Quotes", $Quotes);

    $date = date("d.m.Y");

    $Controller->appendVariable("date", $date);

    return $Controller;
}

?>
