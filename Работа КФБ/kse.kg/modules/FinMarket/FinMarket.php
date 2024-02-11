<?php
$Module = "FinMarket";

function FinMarket_loadController() {
    $Controller = new ControllerClass();

    $Controller->setText("sometext");
	$link = MainClass::getSingleton()->getDbConnection();
    $Uri = MainClass::getSingleton()->getFullUriPath();

    $sql = "SELECT COUNT(*) AS `num` FROM `mod_fin_market`";
    $result = mysqli_query($link, $sql);
    $count = mysqli_fetch_object($result);
    if ($count->num > 10)
            $count = $count->num / 10 + 1;
    else
        $count = 1;
    $pages = array();
    for ($i = 1; $i <= $count; $i++) {
        $pages[$i] = $i;
    }
    $Controller->appendVariable("PagesList", $pages);


    $Page = 0;
    if (isset($Uri[3])) {
        if (is_integer(intval($Uri[3]))) {
            $Page = (intval($Uri[3]) -1) * 10;
        }
    }

    $Controller->appendVariable("ControllerInclusion", "modules/FinMarket/FinMarket.html");

    $sql = "SELECT * FROM `mod_fin_market` ORDER BY `date` DESC LIMIT " . $Page . ",10";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    $FinMarketFiles = array();
    for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
        $_fm = array();
        $_fm['Path'] = $obj->filepath;
        $_fm['Size'] = display_filesize($obj->filesize);
        $_fm['Date'] = $obj->date;
        $_fm['Title'] = $obj->title;
        $_fm['Description'] = $obj->description;
        $_fm['id_row'] = $obj->fin_market_id;

        $FinMarketFiles[] = $_fm;
    }

    

    $Controller->appendVariable("FinMarketFiles", $FinMarketFiles);

    
    
    return $Controller;
}

?>
