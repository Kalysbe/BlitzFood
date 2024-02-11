<?php
$Module = "Rating";

function Rating_loadController() {
	$link = MainClass::getSingleton()->getDbConnection();
    $controller = new ControllerClass();

    $sql = "SELECT `year` FROM `members_rating_info` GROUP BY `year`";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    $years = array();
    for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
        $date = explode("-", $obj->year);
        $years[] = $date[0];
    }
    $controller->appendVariable("available_years", $years);

    $uri = MainClass::getSingleton()->getFullUriPath();
    if (count($uri) == 4) {
        if (is_numeric(intval($uri[3]))) {
            $year = $uri[3] . "-00-00";
            $controller->appendVariable("current_year", $uri[3]);
        } 
    } else {
        $year = date("Y-00-00");
        $controller->appendVariable("current_year", date("Y"));
    }
    $sql = "SELECT
        CAST(`volume` AS UNSIGNED) AS `volume`,`amount`,`count_fin_instr`,`count_market_deal`,`volume_market_deal`,`factor`,`company_name_full`,`company_name_short`
    FROM `members_rating_info`  WHERE (`year`='" . $year . "') ORDER BY `factor` DESC";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    $rating = array();
    for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $info = mysqli_fetch_object($result);
			$rating[$i]['name'] = $info->company_name_full;
			$rating[$i]['volume'] = round(($info->volume) / 1000000, 4);
			$rating[$i]['amount'] = $info->amount;
			$rating[$i]['count_fin_instr'] = $info->count_fin_instr;
			$rating[$i]['count_market_deal'] = $info->count_market_deal;
			$rating[$i]['volume_market_deal'] = round(($info->volume_market_deal)/1000, 4);
			$rating[$i]['factor'] = round(($info->factor),3);
		}
    
    $controller->appendVariable("rating", $rating);
    $controller->appendVariable("ControllerInclusion", "modules/MembersRating/Rating.html");

    return $controller;
}
?>
