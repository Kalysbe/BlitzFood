
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

$companyName = str_replace('"', '', $input['fileInfo']["companyName"]); // Имя компании
$mysql_link = MainClass::getSingleton()->getDbConnection();

$kvartal = explode(";", $input['fileInfo']['kvartal']);
$str_kvartal = trim($kvartal[1]) . ' ' . trim($kvartal[0]); // "Переворот пришедшего квартала из oi.kse.kg"
switch($kvartal[1]) {
    case " Квартал 1":
        $report_type = 'quarterly';
        break;
    case " Квартал 2":
        $report_type = 'quarterly';
        break;
    case " Квартал 3":
        $report_type = 'quarterly';
        break;
    case " Квартал 4":
        $report_type = 'quarterly';
        break;
    default:
        $report_type = 'annual';
}
$date = date("Y-m-d");

if (isset($input['fileInfo']['doc']['docs'])) {
    $sql = "SELECT ls_company_id FROM ls_companies WHERE ls_company_name='ОАО Керемет Банк'";
    $result = mysqli_query($mysql_link, $sql);
    $companyListing = mysqli_fetch_object($result); // Поиск компании в листинге
    $sql = "SELECT brep_company_id FROM brep_companies WHERE title='ОАО Керемет Банк'";
    $result = mysqli_query($mysql_link, $sql);
    $companyInfo = mysqli_fetch_object($result); // Поиск компании в раскрытии информации
    //$docs = json_decode(json_encode($input['fileInfo']['doc']['docs']), true);
    $docs = json_decode($input['fileInfo']['doc']['docs'], true);
    // print_r($company);
    foreach ($docs as $key => $value) {
        echo $key . ' '; 
        if ($key == 'anex_1' || $key == 'anex_2') {continue;}
        if ($key == 'anex_2_1' && $companyInfo->brep_company_id) {
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
                'application/file',
                '2',
                '" . date("Y-m-d H:i:s") . "',
                '" . $date . "',
                '" . $value['file'] . "',
                '" . $companyInfo->brep_company_id . "',
                '" . $str_kvartal . "'
            )";
            mysqli_query($mysql_link, $sql);
            echo 'запись успешно добавилась';
        }
        if ($key != 'anex_2_1' && $companyListing->ls_company_id) {
            $sql = "UPDATE `ls_reports` SET `status`='2' WHERE (
                `ls_company_id`='" . $companyListing->ls_company_id . "' AND
                `type`='" . $key . "'
            )";
            mysqli_query($mysql_link, $sql);
            $sql = "INSERT INTO `ls_reports` (
                `type`,
                `status`,
                `upload_date`,
                `report_date`,
                `filepath`,
                `ls_company_id`
            ) VALUES (
                '" . $key . "',
                '1',
                '" . date("Y-m-d H:i:s") . "',
                '" . date("Y-m-d H:i:s") . "',
                '" . $value['file'] . "',
                '" . $companyListing->ls_company_id . "'
            )";
            mysqli_query($mysql_link, $sql);
            echo 'запись успешно добавилась';
        }
    }
}

if ($input['fileInfo']['doc']['rep']) {
    $rep = json_decode($input['fileInfo']['doc']['rep'], true);
    foreach ($rep as $k => $v) {
        if ($k == 'anex_1' || $k == 'anex_2') {continue;}
        $fields = json_decode($v['xmldoc'], true);
        $html = '';
        $html .='<html><head><meta charset="utf-8"></head><body><div class="content">';
        foreach ($fields['fields'] as $key => $value) {
            if ($value['element']=="header") {
                $html .= '<h4 class="header" style="width:30%;float:right;margin:auto 0;"><b>'.$rep['doc']['rep'][$k]['title'].'</b></h4><br/><br/>';
                $html.='<p class="header" style="width:30%;float:right;">'.$value['name'].'</p><br/><br/><br/><br/><br/>';

            }
            else if($value['element']=="select" && !($value['id']=="select_quarter" || $value['id']=="select_report_date" )){
                $html.='<div><label>'.$value['name'].' : '.$value['value'].'</label></div>';
            }
            else if($value['element']=="select" && $value['id']=="select_quarter"){
                $html.='<div><h4>'.$value.' '.$fields[$key+1]['value'].'</h4></div>';
            }
            else if($value['element']==" h1"){
                $html.='<h1>'.$value['name'].'</h1>';
            }

            else if($value['element']=="h2"){
                $html.='<h2>'.$value['name'].'</h2>';
            }
            else if($value['element']=="h3"){
                $html.='<h3>'.$value['name'].'</h3>';
            }
            else if($value['element']=="h4"){
                $html.='<h4><b>'.$value['name'].'</b></h4>';
            }
            else if($value['element']=="h5"){
                $html.='<h5>'.$value['name'].'</h5>';
            }
            else if($value['element']=="h6"){
                  $html.='<h6>'.$value['name'].'</h6>';
            }
            else if($value['element']=="p"){
                  $html.='<p>'.$value['name'].'</p>';
            }
            else if($value['element']=="span"){
              $html.='<span>'.$value['name'].'</span>';
            }
            else if($value['element']=="input"){
              $html.='<div>';
              if($value['name']){
                $html.='<label>'.$value['name'].' : '.$value['value'].'</label>';
              }
              else{  
                $html.='<label>'.$value['value'].'</label>';
              }
              $html.='</div>';
            }
            else if($value['element']=="input-text-area"){
              $html.='<div>';
              if($value['name']){
                    $html.='<label>'.$value['name'].' : '.$value['value'].'</label>';
              }
              else{  
                $html.='<label>'.$value['value'].'</label>';

              }
              $html.='</div>';
            }
            else if($value['element']=="group"){
                $html.='<div>';
                foreach ($value['items'] as $key => $item) {
                    $html.='<div><label>'.$item['name'].' : '.$item['value'].'</label></div>';
                }
                $html.='</div>';
            } 
            else if($value['element']=="table"){
                if($value['name']){
                  $html.='<h6>'.$value['name'].'</h6>';
                }
              $html.='<table class="tables">';
              $html.='<tr>';
              foreach ($value['headers'] as $key => $header) {
                if($header){
                  $html.='<td>'.$header.'</td>';
                }
                else{
                  $html.='<td style="border-left:hidden;"'.$header.'</td>';
                }
              }
              $html.='</tr>';

            
              foreach ($value['rows'] as $key => $row) {
                $html.='<tr>';
                foreach ($row['cells'] as $key => $cell) {
                    $html.='<td>';
            
                        if($cell['element']=='input'){
                            $html.=$cell['value'];
                        }

                        else if($cell['element']=='label-input'){
                            $html.='<label>'.$cell['name']. ' '.$cell['value'].'</label>';
                        }
                        else{
                            $html.=$cell['name'];
                        }

                    $html.='</td>';
                }
                $html.='</tr>';
              }
            $html.='</table>';
            }
        }
        $html .='</div></body></html>';
        $html.='<style lang="scss" scoped>
            h4{
               font-family: Arial, Helvetica, sans-serif;
               }
               .tables {
               font-family: Arial, Helvetica, sans-serif;
               width: 100%;
               border: 1px solid #ddd;
               /* border-radius: 10px; */
               padding: 5px;

               }
               .tables td, .tables th {
               padding: 8px;
               
               }
               .tables tr:nth-child(even){background-color: #f2f2f2;}
               .tables tr:hover {background-color: #ddd;}
               .tables tr:first-child {
               padding-top: 12px;
               padding-bottom: 12px;
               text-align: left;
               background-color: #90aabb;
               color: white;
               }
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
            @media print{
                .content{
                padding:1mm 1mm 1mm 1mm;
                }
                .header{
                width:30%;
                float:right;
                margin:auto 0;
            }

            }
            </style>';

        if ($k == 'anex_2_1' && $v != null) {
            $sql = "SELECT brep_company_id, brep_company_name FROM brep_companies WHERE title='ОАО Керемет Банк'";
            $result = mysqli_query($mysql_link, $sql);
            $company = mysqli_fetch_object($result);

            $date = date("Y-m-d");

            $filename = $company->brep_company_name . "-" . $report_type . "-" . $date . "_" . time() . ".html";

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
            
            $fp = fopen(__ROOT__ . '/files/BusinessReports/' . $filename, 'w');

            fwrite($fp, $html);

            fclose($fp);
            
        }
        if ($k == 'listing_prospectus' && $v != null) {
            var_dump($v);
             $sql = "SELECT ls_company_id, ls_company_name FROM ls_companies WHERE title='ОАО Керемет Банк'";
            $result = mysqli_query($mysql_link, $sql);
            $company = mysqli_fetch_object($result);
            $date = date("Y-m-d");
            $filename = $company->ls_company_name . "-" . $report_type . "-" . $date . "_" . time() . ".html";
            $sql = "INSERT INTO `ls_reports` (
                `type`,
                `filetype`,
                `status`,
                `upload_date`,
                `report_date`,
                `filepath`,
                `ls_company_id`
            ) VALUES (
                'prospect',
                'application/html'
                '2',
                '" . date("Y-m-d H:i:s") . "',
                '" . date("Y-m-d") . "',
                '" . $filename . "',
                '" . $company->ls_company_id . "'
            )";
            mysqli_query($mysql_link, $sql);
            $filename = $company->ls_company_name . "-" . $report_type . "-" . $date . "_" . time() . ".html";

            $fp = fopen(__ROOT__ . '/Listing/' . $filename, 'w');

            fwrite($fp, $html);

            fclose($fp);
        }
        
    }
}


exit;

/**
 * 
 * 
 * 
 */