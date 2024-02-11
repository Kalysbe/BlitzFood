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
  if ($value['element']=="header") {
    $html .= '<h4 class="header" style="width:30%;float:right;margin:auto 0;"><b>'.$input['doc']['title'].'</b></h4><br/><br/>';
    $html.='<p class="header" style="width:30%;float:right;">'.$value['name'].'</p><br/><br/><br/><br/><br/>';

  }
  else if($value['element']=="select" && !($value['id']=="select_quarter" || $value['id']=="select_report_date" )){
    $html.='<div><label>'.$value['name'].' : '.$value['value'].'</label></div>';

  }
   else if($value['element']=="select" && $value['id']=="select_quarter"){
    $html.='<div><h4>'.$input['doc']['fields'][$key]['value'].' '.$input['doc']['fields'][$key+1]['value'].'</h4></div>';

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
      $html.='<table>';
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
                       $html.='<label>'.$cell['value']. ' '.$cell['value'].'</label>';
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
table,
td,
th {
  border: 0.5px solid lightgrey;
  border-spacing: 0px;
  border-collapse: collapse;
}
td {
  text-align: left;
  padding: 5px;
}
table {
  width: 100%;
}
body{
  zoom:95%;

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
