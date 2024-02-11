<?php

$Module = "BusinessReports";

function get_pages_num() {
	$mysql_link = MainClass::getSingleton()->getDbConnection();
    $sql = "SELECT COUNT(*) AS `num` FROM `brep_companies`";
    $result = mysqli_query($mysql_link, $sql);
    $obj = mysqli_fetch_object($result);
    return $obj->num / 15 + 1;
}

function build_pages_array($num_of_pages) {
    $array = array();
    for ($i = 1; $i <= $num_of_pages; $i++) {
        $array[$i] = $i;
    }
    return $array;
}

function BusinessReports_loadController() {

    $mysql_link = MainClass::getSingleton()->getDbConnection();
	if(isset($_GET['test'])) {
        $id = $_GET['test'];
        $sql = "DELETE FROM brep_reports where brep_report_id = $id";
        $result = mysqli_query($mysql_link, $sql);
    }
	if (isset($_POST["do_upload_report"])) {
        if ($_FILES["report_file"]["error"] === UPLOAD_ERR_OK) {
		$sql = "SELECT `brep_company_id`,`brep_company_name` FROM `brep_companies` WHERE (`brep_company_id`='" . $_POST["CompanyId"] . "')";
            $result = mysqli_query($mysql_link, $sql);
            $company = mysqli_fetch_object($result);
            $kvartal = $_POST['kvartal'];
            $year = $_POST['year'];
            if ($kvartal != 0)
                $str_kvartal = $kvartal . ' квартал ' . $year;
            else 
                $str_kvartal = $year;
            if (trim($_POST["report_date"]) == "")
                $date = date("Y-m-d");
            else
                $date = trim($_POST["report_date"]);
            $report_type = $_POST["report_type"];

            $filename = $company->brep_company_name . "-" . $report_type . "-" . $date . "_" . time() . "_.pdf";
            copy($_FILES["report_file"]["tmp_name"], MainClass::getSingleton()->getSiteVar("%HOME%") . "/files/BusinessReports/" . $filename);

            // Getting old reports with same type for this company
            $sql = "UPDATE `brep_reports` SET `status`='2' WHERE (
                `brep_company_id`='" . $company->brep_company_id . "' AND
                `type`='" . $report_type . "'
            )";
            mysqli_query($mysql_link, $sql);

            $sql = "INSERT INTO `brep_reports` (
                    `type`,
                    `filetype`,
                    `status`,
                    `upload_date`,
                    `report_date`,
                    `filepath`,
                    `brep_company_id`,
                    `kvartal`
                ) VALUES (
                    '" . $report_type . "',
                    '" . $_FILES["report_file"]["type"] . "',
                    '2',
                    '" . date("Y-m-d H:i:s") . "',
                    '" . $date . "',
                    '" . $filename . "',
                    '" . $company->brep_company_id . "',
                    '" . $str_kvartal . "'
                )";
            mysqli_query($mysql_link, $sql);
        }
    }

    if (isset($_POST["doUpdateCompany"])) {
        $request = buildRequestFromPost();
        $sql = "UPDATE `brep_companies` SET ";
        foreach ($request as $k=>$v) {
            if ($k != "doUpdateCompany") {
                $sql.= "
                    `" . $k . "`='" . $v . "',";
            }
        }
        $sql = substr($sql,0, -1);
        $sql.= " WHERE (`brep_company_id`='" . $_POST["brep_company_id"] . "')";
        mysqli_query($mysql_link, $sql);

    }

    if (isset($_POST["doAddCompany"])) {
        $sql = "INSERT INTO `brep_companies` (`brep_company_name`, `title`) VALUES (
            '" . mysqli_real_escape_string($mysql_link, $_POST["name"]) . "',
            '" . mysqli_real_escape_string($mysql_link, $_POST["title"]) . "'
        )";
        mysqli_query( $mysql_link, $sql);
    }

    $controller = new ControllerClass();
    $route = MainClass::getSingleton()->getFullUriPath();
    $controller->appendVariable("this_page", $route[2]);
	$lang_d= MainClass::getSingleton()->getSiteVar("DEFAULT_LANGUAGE");

	if ($lang_d = "ru") 
	{
		$controller->appendVariable("blogName", "RussianAllNewsBlog");
	}
	else
	{
		$controller->appendVariable("blogName", "EnglishAllNewsBlog");
	}	

    // Printing list of comapnies
    if ((!isset($route[3])||($route[3] == ""))) {

        $controller->appendVariable("ControllerInclusion", "modules/BusinessReports/List.html");

        $sql = "SELECT * FROM `brep_companies` WHERE `title` not like 'ЗАО%' ORDER BY `title` DESC LIMIT 0,15";
        $result = mysqli_query($mysql_link, $sql);
        $rows = mysqli_num_rows($result);
        $companies_list = array();
        for ($i = 0; $i < $rows; $i++) {
            mysqli_data_seek($result, $i);
            $company = mysqli_fetch_object($result);
            $companies_list[$i]['name'] = $company->brep_company_name;
            $companies_list[$i]['title'] = $company->title;
        }
        $controller->appendVariable("CompaniesList", $companies_list);
        $controller->appendVariable("pages_list", build_pages_array(get_pages_num()));
    } elseif ((isset($route[3]))&&(trim($route[3]) != "")) {
        $offset = 15;
        if (substr($route[3],0,5) == "Page:") {

            $from = 0;
            $page = explode(":", $route[3]);
            if (($page[1] == "")||($page[1] == 0))
                $page[1] = 0;
            else if (is_numeric(intval($page[1]))) {
                $page[1] = $page[1] * $offset - $offset;
            }
            $from = $page[1];


            $controller->appendVariable("ControllerInclusion", "modules/BusinessReports/List.html");

            $sql = "SELECT * FROM `brep_companies` ORDER BY `title` ASC LIMIT $from,15";
            $result = mysqli_query($mysql_link, $sql);
            $rows = mysqli_num_rows($result);
            $companies_list = array();
            for ($i = 0; $i < $rows; $i++) {
                mysqli_data_seek($result, $i);
                $company = mysqli_fetch_object($result);
                $companies_list[$i]['name'] = $company->brep_company_name;
                $companies_list[$i]['title'] = $company->title;
            }
            $controller->appendVariable("CompaniesList", $companies_list);
            $controller->appendVariable("pages_list", build_pages_array(get_pages_num()));
        } else {
            $controller->appendVariable("ControllerInclusion", "modules/BusinessReports/Details.html");
			
            $sql = "SELECT * FROM `brep_companies` WHERE (`brep_company_name`='" .
                mysqli_real_escape_string($mysql_link, trim($route[3])) .
                "')";
            $result = mysqli_query($mysql_link, $sql);
            $rows = mysqli_num_rows($result);
            if ($rows == 0) {

            } else {
                $company = mysqli_fetch_object($result);
                $company_info['id'] = $company->brep_company_id;
                $company_info['name'] = $company->brep_company_name;
                $company_info['title'] = $company->title;
                $company_info['sphere'] = $company->sphere;
                $company_info['activity'] = $company->activity;
                $company_info['date'] = $company->cr_date;
                $company_info['owner'] = $company->owner;
                $company_info['owner_position'] = $company->owner_position;
                $company_info['address'] = $company->address;
                $company_info['phone'] = $company->phone;
                $company_info['auditor'] = $company->auditor;
                $company_info['registrar'] = $company->registrar;
				$company_info['t_securities'] = $company->t_securities;
				$company_info['n_issues'] = $company->n_issues;
				$company_info['n_securities'] = $company->n_securities;
				$company_info['f_price'] = $company->f_price;
                $controller->appendVariable("company_info", $company_info);

                $sql = "SELECT *,(SELECT MAX(`report_date`) FROM `brep_reports` br_in WHERE `brep_company_id`='" . $company_info['id'] . "' and br_in.type=br_out.type ) as maxdate,
				CASE(MONTH(`report_date`))
                WHEN 1 THEN CONCAT('4 квартал ',YEAR(`report_date`)-1)
				WHEN 2 THEN CONCAT('4 квартал ',YEAR(`report_date`)-1)
				WHEN 3 THEN CONCAT('4 квартал ',YEAR(`report_date`)-1)
				WHEN 4 THEN CONCAT('1 квартал ',YEAR(`report_date`))
				WHEN 5 THEN CONCAT('1 квартал ',YEAR(`report_date`))
				WHEN 6 THEN CONCAT('1 квартал ',YEAR(`report_date`))
				WHEN 7 THEN CONCAT('2 квартал ',YEAR(`report_date`))
				WHEN 8 THEN CONCAT('2 квартал ',YEAR(`report_date`))
				WHEN 9 THEN CONCAT('2 квартал ',YEAR(`report_date`))
				WHEN 10 THEN CONCAT('3 квартал ',YEAR(`report_date`))
				WHEN 11 THEN CONCAT('3 квартал ',YEAR(`report_date`))
				WHEN 12 THEN CONCAT('3 квартал ',YEAR(`report_date`))
				END AS kvdate FROM `brep_reports` br_out WHERE (`brep_company_id`='" . $company_info['id'] . "' AND `type` != 'news') ORDER BY `report_date` DESC";
                $result = mysqli_query($mysql_link, $sql);
                $rows = mysqli_num_rows($result);

                $Reports = array();
                $ReportsArchive = array(
                    "bulletin" => array(),
                    "quarterly" => array(),
                    "annual" => array(),
                    "news" => array(),
                    "analytics" => array()
                );
                for ($i = 0; $i < $rows; $i++) {
                    mysqli_data_seek($result, $i);
                    $Report = mysqli_fetch_object($result);
                    $_r = array();
                    switch ($Report->type) {
                        case "bulletin":
                            $_r['Name'] = 'Бюллетень эмитента';
                            break;
                        case "quarterly":
                            $_r['Name'] = 'Ежеквартальный отчёт';
                            break;
                        case "annual":
                            $_r['Name'] = 'Годовой отчёт';
                            break;
                        /*case "news":
                            $_r['Name'] = 'Сообщение о существенном факте';
                            break;*/
                        case "analytics":
                            $_r['Name'] = 'Аналитика';
                            break;
                        default:
                            $_r['Name'] = 'Неизвестно';
                            break;
                    };


                    $_r['brep_report_id'] = $Report->brep_report_id;
                    $_r['Filepath'] = $Report->filepath;
                    $_r['Status'] = $Report->status;
                    $_r['Type'] = $Report->type;
                    $_r['Date'] = $Report->report_date;
                    if ($Report->kvartal == null) {
                        $_r['kvdate'] = $Report->kvdate;
                    } else {
                        $_r['kvdate'] = $Report->kvartal;
                    }
                    $_r['kvartal'] = $Report->kvartal;

					$_r['maxdate'] = $Report->maxdate;
                    if ($Report->report_date == $Report->maxdate)
                        $Reports[] = $_r;
                    /*elseif ($Report->status == 2) {
                        $ReportsArchive[$Report->type][] = $_r;
                    }*/
                    $ReportsArchive[$Report->type][] = $_r;
                    $controller->appendVariable("Reports", $Reports);
                    $controller->appendVariable("ReportsArchive", $ReportsArchive);
                }
			  $sql1 = "SELECT blogentry_id, cr_date, title FROM `Blog_Entries` where link_company_id='" . $company_info['id'] . "' ORDER BY `cr_date` DESC";
			  
              $result1 = mysqli_query($mysql_link, $sql1);
              $rows1 = mysqli_num_rows($result1);
              $news_list = array();
              for ($i = 0; $i < $rows1; $i++) 
			  {
                  mysqli_data_seek($result1, $i);
                  $news = mysqli_fetch_object($result1);
                  $news_list[$i]['news_id'] = $news->blogentry_id;
                  //$news_list[$i]['news_date'] = $news->cr_date;
				  $news_list[$i]['news_date'] = date("d.m.Y", strtotime($news->cr_date));
				  $news_list[$i]['news_title'] = $news->title;				  
              }
              $controller->appendVariable("NewsList", $news_list);
				
            }
        }
    }

    return $controller;
}

?>
