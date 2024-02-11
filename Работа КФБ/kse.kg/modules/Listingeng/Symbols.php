<?php

if (isset($_POST["doUpdateSymbols"])) {
    require_once("../../config.inc.php");
    require_once("../../mainfile.php");

    $Symbols = explode("\n", $_POST["SymbolsList"]);
    foreach ($Symbols as $k=>$v) {
        $v = trim($v);
        if ($v != "") {
            $Symbols[$k] = $v;
        }
    }

    $sql = "DELETE FROM `ls_trade_symbols` WHERE (`ls_company_id`='" . $_POST["CompanyId"] . "')";
    mysql_query($sql);
    foreach ($Symbols as $s) {
        mysql_query("INSERT INTO `ls_trade_symbols` (`ls_company_id`, `trade_symbol`) VALUES (
            '" . $_POST["CompanyId"] . "',
            '" . $s . "'
        )");
    }

    Header("Location: " . $_POST["url"]);
    exit();
}

?>
