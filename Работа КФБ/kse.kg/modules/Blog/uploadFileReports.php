<?php
define('__ROOT__', dirname(dirname(dirname(__FILE__))));

require_once(__ROOT__ . '/config.inc.php');
require_once(__ROOT__ . '/mainfile.php');
// TODO: Totally remake this module
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

error_reporting(0);
// Парсинг json от oi.kse
$inputJson = file_get_contents('php://input');
$input = json_decode($inputJson, true);
$kvartal = explode(";", $input['kvartal']);
$str_kvartal = $kvartal[1] . ' ' . $kvartal[0]; // "Переворот пришедшего квартала из oi.kse.kg"
$str = str_replace('"', '', $input['company_name']); // Имя компании


 $html .='<html><head><meta charset="utf-8"></head><body><div class="content">';

 foreach ($input['doc']['fields'] as $key => $value) {
  
 }
  $html .='</div></body></html>';
 $html.='<style lang="scss" scoped>
  body{
   zoom:95%;
   font-family: Arial, Helvetica, sans-serif;
  }
  .content{
    padding:15px 250px 15px 250px;
  }
  .header{
    width:20%;
    float:right;
    margin:auto 0;
  }
</style>';
/*
//add to data base
$mysql_link = MainClass::getSingleton()->getDbConnection();

$sql = "SELECT brep_company_id, brep_company_name FROM brep_companies WHERE title='" . $str . "'";
            $result = mysqli_query($mysql_link, $sql);
            $company = mysqli_fetch_object($result);

            $date = date("Y-m-d");
                
            switch($input['doc']['fields'][1]['value']) {
                case 'Годовой отчет':
                    $report_type = 'annual';
                    break;
                case 'Квартал 1':
                    $report_type = 'quarterly';
                    break;
                case 'Квартал 2':
                    $report_type = 'quarterly';
                    break;
                case 'Квартал 3':
                    $report_type = 'quarterly';
                    break;
                case 'Квартал 4':
                    $report_type = 'quarterly';
                    break;

                default:
                    $report_type = 'неизвестно';
            }

            $filename = $company->brep_company_name . "-" . $report_type . "-" . $date . "_" . time() . ".html";

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
                    'application/html',
                    '2',
                    '" . date("Y-m-d H:i:s") . "',
                    '" . $date . "',
                    '" . $filename . "',
                    '" . $company->brep_company_id . "',
                    '" . $str_kvartal . "'
                )";
            mysqli_query($mysql_link, $sql);
//

$fp = fopen(__ROOT__ . '/files/BusinessReports/' . $filename, 'w');

fwrite($fp, $html);

fclose($fp);

echo  $filename;

exit ;

/**
 * 
 * 
 * 
 */
