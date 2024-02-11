<?php


$Module = "FinancialReports";

class Company {
    public $Name;
    public $Title;
};

function FinancialReports_loadController() {
    $Controller = new ControllerClass();

    $uri_path = MainClass::getSingleton()->getFullUriPath();
    $Page = "List";
    if (count($uri_path) > 3) {
        if (trim($uri_path[3]) != "") {
            $Page = "Object";
            $CompanyName = $uri_path[3];
            // The one company was required
        }
    }

    $Companies = array();

    if ($Page == "List") {
        $Controller->appendVariable("ControllerInclusion", "modules/FinancialReports/List.html");
        $sql = "SELECT * FROM `mod_finrep_companies` ORDER BY `company_name` DESC";
        $result = mysql_query($sql);
        $rows = mysql_num_rows($result);

        for ($i = 0; $i < $rows; $i++) {
            mysql_data_seek($result, $i);
            $obj = mysql_fetch_object($result);
            $c = new Company();
            $c->Name = $obj->company_name;
            $c->Title = $obj->company_title;
            $Companies[] = $c;
        }
    } elseif ($Page == "Object") {
        $Controller->appendVariable("ControllerInclusion", "modules/FinancialReports/Company.html");

        $sql = "SELECT * FROM `mod_finrep_companies` WHERE (`company_name`='" . trim($CompanyName) . "')";
        $result = mysql_query($sql);
        $rows = mysql_num_rows($result);

        if ($rows != 1) {
            $Controller->appendVariable("NoSuchCompany", 1);
        } else {
            $obj = mysql_fetch_object($result);
            $Controller->appendVariable("CompanyTitle", $obj->company_title);

            
        }
    }

    $Controller->appendVariable("Companies", $Companies);

    return $Controller;
}

?>
