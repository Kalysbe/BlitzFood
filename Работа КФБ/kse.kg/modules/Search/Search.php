<?php


$Module = "Search";
$Module1 = "NewSearch";

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

function Search_loadController() {
    
	$link = MainClass::getSingleton()->getDbConnection();
	$Controller = new ControllerClass();
    	$Uri = MainClass::getSingleton()->getFullUriPath();
    	$Controller->appendVariable("ControllerInclusion", "modules/Search/Search.html");
	//получаем данные через $_POST
	   
	if (isset($_POST["search"])) {
		include('db.php');
	    	$db = new db();
	    	$word = mysqli_real_escape_string($link, $_POST["search"]);
		// Строим запрос
		$sql = "SELECT * FROM brep_companies WHERE title LIKE '%" . $word . "%' ORDER BY cr_date LIMIT 15";
	    	//$sql = "SELECT * FROM Blog_Entries WHERE title LIKE '%" . $word . "%' ORDER BY cr_date LIMIT 15";	
		
		
	    	$row = $db->select_list($sql);
	 
		$Search=$row;

	}

if (isset($_POST["search_top"])) {
	include('db.php');
    	$db = new db();
    	$word = mysqli_real_escape_string($link, $_POST["search_top"]);
	// Строим запрос
	$sql = "SELECT brep_company_name, title FROM brep_companies WHERE title LIKE '%" . $word . "%' ORDER BY cr_date LIMIT 15";
    $sql1 = "SELECT blogentry_id, title, DATE_FORMAT(cr_date,'%d-%m-%Y') as public_date FROM Blog_Entries WHERE title LIKE '%" . $word . "%' ORDER BY cr_date DESC LIMIT 15";
    $sql2 = "SELECT ls_company_id, ls_company_name FROM `ls_companies` WHERE ls_company_name LIKE '%" . $word . "%'";

	/*$sql = "SELECT name.Blog_Entries, blogentry_id.Blog_Entries, title.brep_companies, cr_date.brep_companies FROM Blog_Entries, brep_companies 
    WHERE Blog_Entries.title LIKE '%" . $word . "%' AND brep_companies.title LIKE '%" . $word . "%'";*/
	
	
    	$row = $db->select_list($sql); 

    	$row1 = $db->select_list($sql1);

    	$row2 = $db->select_list($sql2); 
	
	$Search=$row;
	$Search1 = $row1;
	$Controller->appendVariable("NewSearch", $Search1);
	$result = mysqli_query($link, $sql2);
	$ListingList = array();
    $rows = mysqli_num_rows($result);
     for ($i = 0; $i < $rows; $i++) {
     	mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
        $TradeSymbols = getTradeSymbols($obj->ls_company_id);
        $ListingList[] = "http://www.kse.kg/ru/ListingDetails/" . $TradeSymbols[0];
        $ListingList[] = $obj->ls_company_name;
     }
     $Controller->appendVariable("ListingList", array_chunk($ListingList, 2));
}


if (isset($_POST["referal"])) {
	include('db.php');
    	$db = new db();
    	$word = mysqli_real_escape_string($link, $_POST["referal"]);
	// Строим запрос
	$sql = "SELECT * FROM brep_companies WHERE title LIKE '%" . $word . "%' ORDER BY cr_date LIMIT 15";
    	//$sql = "SELECT * FROM Blog_Entries WHERE title LIKE '%" . $word . "%' ORDER BY cr_date LIMIT 15";
	
	
		
    $row = $db->select_list($sql);

	foreach ($row as $v) {
		echo "\n<li><a href='http://www.kse.kg/ru/PublicInfo/" . $v["brep_company_name"] . "'>" . $v["title"] . "</a></li>";
	}
 
	//print_r($row);

exit;

}


    $Controller->appendVariable("Search", $Search);
 
    return $Controller;
	

}
?>