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
$str = str_replace('"', '', $input['doc']["reportHead"]["name"]); // Имя компании

// 1. Данные об эмитенте and 2. Количество владельцев ценных бумах и работников эмитента.
$html = '<head><meta charset="utf-8"> <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"></head><body> <div class="container"><div class="container"><h4>' . $str_kvartal . '</h4><h4>1. Данные об эмитенте:</h4> <div role="group" class="input-group mt-3"> <div class="input-group-prepend"> <div class="input-group-text">полное и сокращенное наименование эмитента</div></div><input type="text" readonly="readonly" class="form-control" value = "';
$html .= $str . '" id="__BVID__72" style="background: rgb(255, 255, 255);"/> <div class="input-group-append"> </div></div><div role="group" class="input-group mt-3"> <div class="input-group-prepend"> <div class="input-group-text">организационно-правовая форма</div></div><input type="text" readonly="readonly" class="form-control" value ="';
$html .= $input['doc']['reportHead']['opforma'] . '" id="__BVID__73" style="background: rgb(255, 255, 255);"/> <div class="input-group-append"> </div></div><div role="group" class="input-group mt-3"> <div class="input-group-prepend"> <div class="input-group-text">юридический и почтовый адрес эмитента, номер телефона и факса</div></div><input type="text" readonly="readonly" class="form-control" value="';
$html .= $input['doc']['reportHead']['address'] . '" id="__BVID__74" style="background: rgb(255, 255, 255);"/> <div class="input-group-append"> </div></div><div role="group" class="input-group mt-3"> <div class="input-group-prepend"> <div class="input-group-text">основной вид деятельности эмитента</div></div><input type="text" readonly="readonly" class="form-control" value="';
$html .= $input['doc']['reportHead']['activity'] . '" id="__BVID__75" style="background: rgb(255, 255, 255);"/> <div class="input-group-append"> </div></div><h4>2. Количество владельцев ценных бумах и работников эмитента.</h4> <div class="row"> <div class="col-8"> <div role="group" class="input-group mt-3"> <div class="input-group-prepend"> <div class="input-group-text">Количество владельцев</div></div><input type="text" required="required" readonly="readonly" value="';
$html .= $input['doc']['reportHead']['owners'] . '" aria-required="true" class="form-control" id="__BVID__76"/> <div class="input-group-append"> </div></div><div role="group" class="input-group mt-3"> <div class="input-group-prepend"> <div class="input-group-text">Количество работников</div></div><input type="text" readonly="readonly" value="';
$html .= $input['doc']['reportHead']['workers'] . '" class="form-control" id="__BVID__77"/> <div class="input-group-append"> </div></div></div></div>';

// 3. Список юридических лиц, в которых данный эмитент владеет 5 процентами и более уставного капитала.

$html .= '<h4>3. Список юридических лиц, в которых данный эмитент владеет 5 процентами и более уставного капитала.</h4> <table class="table table-bordered mt-4"> <thead class="thead-light"> <tr> <th width="10%">Наименование юридического лица</th> <th width="10%">Организационно-правовая форма</th> <th width="10%">Местонахождение, почтовый адрес,телефон,факс,адрес электронной почты и код ОКПО</th> <th width="10%">Доля участия в уставном капитале</th> </tr></thead> <tbody> ';
foreach ($input['doc']['tblOwners'] as $value) {
    $html .= '<tr>';
    foreach ($value as $v) {
        $html .= '<td> ' . $v . '</td>';
    }
    $html .= '</tr>';
}

$html .= '</tbody></table>';

//4. Информация о существенных фактах (далее - факт), затрагивающих деятельность эмитента ценных бумаг в отчетном периоде.

$html .= '<h4>4. Информация о существенных фактах (далее - факт), затрагивающих деятельность эмитента ценных бумаг в отчетном периоде.</h4> <table role="table" aria-busy="false" aria-colcount="4" class="table b-table table-bordered" id="__BVID__78"> <thead role="rowgroup" class="thead-light"> <tr role="row" class=""> <th role="columnheader" scope="col" title="Наименование факта" aria-colindex="1" class="">Наименование факта</th> <th role="columnheader" scope="col" title="Дата появления факта" aria-colindex="2" class="">Дата появления факта</th> <th role="columnheader" scope="col" title="Влиянии факта на деятельность" aria-colindex="3" class="">Влиянии факта на деятельность</th> <th role="columnheader" scope="col" title="Дата и форма раскрытия" aria-colindex="4" class="">Дата и форма раскрытия</th> </tr></thead> <tbody role="rowgroup">';
foreach ($input['doc']['tblfact'] as $value) {
    $html .= '<tr>';
    foreach ($value as $v) {
        $html .= '<td> ' . $v . '</td>';
    }
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// 5. Финансовая отчетность эмитента за отчетный квартал

// 1) Сведения, включаемые в бухгалтерский баланс

$html .= '<h4>5. Финансовая отчетность эмитента за отчетный квартал</h4> <p>1) Сведения, включаемые в бухгалтерский баланс</p><table role="table" aria-busy="false" aria-colcount="4" class="table b-table table-hover table-bordered" id="__BVID__90"> <thead role="rowgroup" class="thead-light"> <tr role="row" class=""> <th role="columnheader" scope="col" title="Код строк" aria-colindex="1" class="">Код строк</th> <th role="columnheader" scope="col" title=" " aria-colindex="2" class="table-transparent text-left" style="width:40%"></th> <th role="columnheader" scope="col" title="Начало отчетного периода, тыс.сом" aria-colindex="3" class="text-center">Начало отчетного периода, тыс.сом</th> <th role="columnheader" scope="col" title="На конец отчетного периода, тыс сом" aria-colindex="4" class="text-center">На конец отчетного периода, тыс сом</th> </tr></thead> <tbody role="rowgroup">';

foreach ($input['doc']['tblBalance'] as $value) {
    $html .= '<tr>';
    if (!array_key_exists('Code', $value)) {
        $html .= '<td></td>';
    }
    foreach ($value as $k => $v) {

        $html .= '<td> ' . $v . '</td>';
    }
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// 2) Сведения, включаемые в отчет о прибылях и убытках

$html .= '<p>2) Сведения, включаемые в отчет о прибылях и убытках</p><table role="table" aria-busy="false" aria-colcount="4" class="table b-table table-hover table-bordered" id="__BVID__114"> <thead role="rowgroup" class="thead-light"> <tr role="row" class=""> <th role="columnheader" scope="col" title="Код строк" aria-colindex="1" class="">Код строк</th> <th role="columnheader" scope="col" title=" " aria-colindex="2" class="table-transparent text-left" style="width:40%"></th> <th role="columnheader" scope="col" title="Начало отчетного периода, тыс.сом" aria-colindex="3" class="text-center">Начало отчетного периода, тыс.сом</th> <th role="columnheader" scope="col" title="На конец отчетного периода, тыс сом" aria-colindex="4" class="text-center">На конец отчетного периода, тыс сом</th> </tr></thead> <tbody role="rowgroup">';

foreach ($input['doc']['tblProfit'] as $value) {
    $html .= '<tr>';
    foreach ($value as $v) {
        $html .= '<td> ' . $v . '</td>';
    }
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// 3) Сведения, включаемые в отчет об изменениях в капитале

$html .= '<p>3) Сведения, включаемые в отчет об изменениях в капитале</p><table role="table" aria-busy="false" aria-colcount="4" class="table b-table table-hover table-bordered" id="__BVID__132"> <thead role="rowgroup" class="thead-light"> <tr role="row" class=""> <th role="columnheader" scope="col" title="Код строк" aria-colindex="1" class="">Код строк</th> <th role="columnheader" scope="col" title=" " aria-colindex="2" class="table-transparent text-left" style="width:40%"></th> <th role="columnheader" scope="col" title="Начало отчетного периода, тыс.сом" aria-colindex="3" class="text-center">Начало отчетного периода, тыс.сом</th> <th role="columnheader" scope="col" title="На конец отчетного периода, тыс сом" aria-colindex="4" class="text-center">На конец отчетного периода, тыс сом</th> </tr></thead> <tbody role="rowgroup">';

foreach ($input['doc']['tblCapital'] as $key => $value) {
    $html .= '<tr>';
    foreach ($value as $k => $v) {
        if ($key == 0 || $key == 9) {
            if ($k == 'TItle')
                $html .= '<td> Сальдо на ' . $v . '</td>';
            else
                $html .= '<td> ' . $v . '</td>';
        } else
            $html .= '<td> ' . $v . '</td>';
    }
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// Textareas

$html .= '<div class="row"> <div class="col-sm-12"> <p> 6. Сведения о направлении средств, привлеченных эмитентом в результате размещения эмиссионных ценных бумаг, которые включают в себя: общий объем привлеченных средств, сведения о привлеченных средствах, использованных по каждому из направлений, и о направлениях использования привлеченных средств. </p><textarea id="textarea-rows" readonly="readonly" rows="2" wrap="soft" class="form-control">' . $input['doc']['reportFooter']['placement'] . '</textarea> </div></div>';

$html .= '<div class="row"> <div class="col-sm-12"> <p> 7. Заемные средства, полученные эмитентом и его дочерними обществами в отчетном квартале. Данный пункт отражает заемные средства, полученные эмитентом в отчетном квартале, и заемные средства, полученные дочерними обществами в отчетном квартале. </p><textarea id="textarea-rows" readonly="readonly" rows="2" wrap="soft" class="form-control">' . $input['doc']['reportFooter']['funds'] . '</textarea> </div></div>';

$html .= '<div class="row"> <div class="col-sm-12"> <p>8. Сведения о долгосрочных и краткосрочных финансовых вложениях эмитента за отчетный квартал.</p><textarea id="textarea-rows" readonly="readonly" rows="2" wrap="soft" class="form-control">' . $input['doc']['reportFooter']['investment'] . '</textarea> </div></div>';

$html .= '<div class="row"> <div class="col-sm-12"> <p> 9. Доходы по ценным бумагам эмитента. Эта информация представляется при начислении доходов по ценным бумагам эмитента в отчетном квартале или в квартале, предшествующем отчетному кварталу, и включает: вид ценной бумаги, размер доходов, начисленных на одну ценную бумагу,и общую сумму доходов, начисленных по ценным бумагам данного вида. </p><textarea id="textarea-rows" rows="2" wrap="soft" readonly="readonly" class="form-control">' . $input['doc']['reportFooter']['income'] . '</textarea> </div></div>';

$html .= '<div class="row"> <div class="col-sm-12"> <p> 10. Информация об условиях и характере сделки, совершенной лицами, заинтересованными в совершении обществом сделки, включает: дату совершения сделки, информацию о влиянии сделки на деятельность эмитента (финансовый результат, дополнительные инвестиции и т.д.), информацию об условиях и характере заключенной сделки (предмет, условия, цена сделки и т.д.), степень имеющейся заинтересованности (лица, заинтересованного в сделке), дату опубликования информации о сделке в средствах массовой информации (прилагается копия опубликованного сообщения), а также дату направления уведомления с информацией о сделке в уполномоченный орган по регулированию рынка ценных бумаг. </p><textarea readonly="readonly" id="textarea-rows" rows="2" wrap="soft" class="form-control">' . $input['doc']['reportFooter']['deal'] . '</textarea> </div></div>';

if ($input['doc']['typedoc'] == 'RKV02') {
    $html .= '<div class="row"> <div class="col-sm-12"> <p> 11. Аудиторское заключение </p><textarea id="textarea-rows" rows="2" wrap="soft" readonly="readonly" class="form-control">' . $input['doc']['reportFooter']['audit'] . '</textarea> </div></div>';
}

$html .= '<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script></body>';


$mysql_link = MainClass::getSingleton()->getDbConnection();

$sql = "SELECT brep_company_id, brep_company_name FROM brep_companies WHERE title='" . $str . "'";
            $result = mysqli_query($mysql_link, $sql);
            $company = mysqli_fetch_object($result);

            $date = date("Y-m-d");
                
            switch($input['doc']['typedoc']) {
                case 'RKV02':
                    $report_type = 'annual';
                    break;
                case 'RKV01':
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


$fp = fopen(__ROOT__ . '/files/BusinessReports/' . $filename, 'w');

fwrite($fp, $html);

fclose($fp);

echo  $filename;


exit;

/**
 * 
 * 
 * 
 */
