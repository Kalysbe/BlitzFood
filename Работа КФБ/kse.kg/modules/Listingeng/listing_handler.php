<?php


function getTradeSymbols($company_id) {
    $link = MainClass::getSingleton()->getDbConnection();
	$sql = "SELECT * FROM `ls_trade_symbols` WHERE (`ls_company_id`='" .
        $company_id . "') ";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    $buffer = array();
    for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
        $buffer[] = $obj->trade_symbol;
    }
    return $buffer;
}

function getProspectFile($company_id) {
    $link = MainClass::getSingleton()->getDbConnection();
	$sql = "SELECT * FROM `ls_reports` WHERE (`ls_company_id` = '" .
    $company_id . "' AND `status`='1' AND `type`='prospect')";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    if ($rows < 1)
        return "";

    $obj = mysqli_fetch_object($result);
    return $obj->filepath;
}

function getCompanyInfo($company_id) {
    $Info =
    array(
        "last_price"=>"-",
        "capitalization"=>"-",
        "securities_amount"=>"-"
    );
    $link = MainClass::getSingleton()->getDbConnection();
	$sql = "SELECT * FROM `ls_info` WHERE (`ls_company_id`='" . $company_id . "')";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    if ($rows > 0) {
        $obj = mysqli_fetch_object($result);
        $Info["last_price"] = $obj->last_price;
        $Info["capitalization"] = $obj->capitalization;
        $Info["securities_amount"] = $obj->securities_amount;
    }
    return $Info;
}

function Listingeng_getModuleBuffer() {
    $buffer = "";
	
	$link = MainClass::getSingleton()->getDbConnection();
    $sql = "SELECT * FROM `ls_categories` ORDER BY `ls_cat_id` ASC";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    $Category = array();
    for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
        $Category[$obj->ls_cat_id] = $obj->ls_short_name;
    }

    $sql = "SELECT `ls_companies`.* FROM `ls_companies` ORDER BY `ls_cat_id` ASC";
    $result = mysqli_query($link, $sql);

    $rows = mysqli_num_rows($result);
    $buffer.= "
        <table class=\"class1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
            <tbody>
                <tr>
                    <th>Issuer</th>
                    <th>Stock/Security</th>
                    <th>Price of the last transaction, som</th>
                    <th>Capitalization mln, som</th>
                    <th>Amount of stock</th>
                    <th>Form</th>
                </tr>
            </tbody>
    ";
    $current_cat = 0;
    for ($i = 0; $i < $rows; $i++) {

        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);

        $TradeSymbols = getTradeSymbols($obj->ls_company_id);
        if (count($TradeSymbols) == 0)
            $TradeSymbols[0] = "NONE" . $obj->ls_company_id;

        if ($current_cat != $obj->ls_cat_id) {
            $current_cat = $obj->ls_cat_id;
            $buffer.= "
                <tbody class=\"listing_category\">
                    <tr>
                        <td>Category " . $Category[$obj->ls_cat_id] . "</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            ";
        }

        if (getProspectFile($obj->ls_company_id) != "") {
            $Prospect = "<center><a href=\"http://www.kse.kg/Listing/" .
            getProspectFile($obj->ls_company_id) . "\">
                <img src=\"http://www.kse.kg/views/kse/images/icon_pdf.jpg\" width=\"20px\" />
                </a></center>";
        } else {
            $Prospect = "";
        }

        $Info = getCompanyInfo($obj->ls_company_id);

        $buffer.= "
            <tbody>
                <tr>
                    <td><a href=\"" .
                        MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" .
                        MainClass::getSingleton()->getLanguageCode() . "/" .
                        "ListingDetails/" . $TradeSymbols[0] .
                    "\">" . $obj->ls_company_name_eng . "</a></td>
                    <td>" . $obj->security_eng . "</td>
                    <td>" . $Info["last_price"] . "</td>
                    <td>" . $Info["capitalization"] . "</td>
                    <td>" . $Info["securities_amount"] . "</td>
                    <td>" . $Prospect . "</td>
                </tr>
            </tbody>
            ";
    }
    $buffer.= "</table>";
    return $buffer;
}

?>
