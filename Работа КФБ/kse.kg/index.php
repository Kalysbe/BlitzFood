<?php

/*
 *  BUSE - BUisiness Site Engine
 *  Copyright (C) 2010  Epos Software Foundation
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
$Variables = array();
require_once('config.inc.php');
require_once('mainfile.php');
require_once('includes/language.class.php');
include_once('includes/page.class.php');
require_once('includes/user.class.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: *");

    // SAPE

     if (!defined('_SAPE_USER')){
        define('_SAPE_USER', 'adc3c0bec5fbce8f3da6f68e6c84d047');
     }

     //if (file_exists($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php')) {
		require_once($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php');

		$o = array();
		$o['charset'] = 'UTF-8';
		//$o['force_show_code'] = true;
		//$o['request_uri'] = $_SERVER['REDIRECT_URL'];

        $sape = new SAPE_client($o);
		
		unset($o);
    // SAPEEND
         $Variables["SapeCode"] = $sape->return_links();
     //}

$Language = new Language(MainClass::getSingleton()->getLanguageCode());

$Page = new Page(MainClass::getSingleton()->getNamespace());
$Variables = array_merge($Variables, $Page->getVariables());
$Variables["lang"] = $Language->getLang();

if (MainClass::getSingleton()->getUriPath(3)) {
    $SubPage = new Page(MainClass::getSingleton()->getUriPath(3), 0, true);
    $SubPage->translate($Language->getLang());
    $Variables["SubPage"] = new PageInfo();
    $Variables["SubPage"]->Id = $SubPage->getId();
    $Variables["SubPage"]->Title = $SubPage->getTitle();
    $Variables["SubPage"]->Text = $SubPage->getText();
    $Variables["SubPage"]->Status = $SubPage->getStatus();
    $Variables["SubPage"]->Uname = $SubPage->getUname();
    $Variables["SubPageUri"] = MainClass::getSingleton()->getUriPath(3);
}

$Variables["Page"] = new PageInfo();
$Variables["Page"]->Id = $Page->getId();
$Variables["Page"]->Title = $Page->getTitle();
$Variables["Page"]->Text = strtr($Page->getText(), $Language->getLang());
$Variables["Page"]->Status = $Page->getStatus();
$Variables["Page"]->Uname = $Page->getUname();

/*$SubPage = MainClass::getSingleton()->getUriPath(3);
if ($SubPage) {
    $Variables["SubPage"] = new Page($SubPage, 0, true);
    $Variables["SubPage"]->translate($Language->getLang());
}*/

$dbConnect =  MainClass::getSingleton()->getDbConnection();

$sql = "SELECT `views_pages`.`page_name`
    FROM `views_pages` , `views`
    WHERE (
    `views`.`status` = '1'
    AND `views_pages`.`views_name` = `views`.`name`
    )";
$result = mysqli_query($dbConnect, $sql);
$rows = $result->num_rows;
for ($i = 0; $i < $rows; $i++) {
    mysqli_data_seek($result, $i);
    $obj = mysqli_fetch_object($result);
    $ViewsPage = new Page($obj->page_name);
    $Variables["ViewsPage_" . $obj->page_name] = new PageInfo();
    $Variables["ViewsPage_" . $obj->page_name]->Title = $ViewsPage->getTitle();
    $Variables["ViewsPage_" . $obj->page_name]->Text = strtr($ViewsPage->getText(), $Language->getLang());
}

$Variables["Lang"] = $Language->getLang();
$Variables["Logged"] = MainClass::getSingleton()->checkUserLogin();
$Variables["lang_code"] = $_SESSION["LANGUAGE"];
$Variables["main_page"] = MainClass::getSingleton()->getSiteVar("MAIN_PAGE");
$Variables["root"] = MainClass::getSingleton()->getSiteVar("%ROOT%");

require_once('views/default/config/config.php');
foreach ($_SKIN["REQUIRED_PAGES"] as $PageName) {
    $Variables[$PageName] = new Page($PageName);
    $Variables[$PageName]->translate($Language->getLang());
}

if (MainClass::getSingleton()->checkUserLogin()) {
    $Variables["LoggedUser"] = new User(MainClass::getSingleton()->getLoggedUid());
    $Variables["LoggedLevel"] = MainClass::getSingleton()->getUserLevel();
}



$Variables = array_merge($Variables, MainClass::getSingleton()->getVariables());

if (isset($_SESSION["ERROR"]))
{
    foreach ($_SESSION["ERROR"] as $k => $v)
    {
        $Variables["errors"][] = strtr($v, $Language->getLang());
    }
    unset($_SESSION["ERROR"]);
}

if (isset($_SESSION["MESSAGE"]))
{
    foreach ($_SESSION["MESSAGE"] as $k => $v)
    {
        $Variables["messages"][] = strtr($v, $Language->getLang());
    }
    unset($_SESSION["MESSAGE"]);
}


$pageToShow = "main.html";
$result = mysqli_query($dbConnect, "SELECT `inner_page`,`inner_page_attachment` FROM `views` WHERE `status`=1");
$rows = $result->num_rows;

if ($rows >= 1) {
    $obj = mysqli_fetch_object($result);
    if (MainClass::getSingleton()->isInner()) {
        if (count($Page->getAttachments()) > 0) {
            $att = $Page->getAttachments();
            foreach ($att as $k=>$v) {
                $v["Icon"] = strtr($v["Mime"], $mime_types);
                $v["Size"] = display_filesize($v["Size"]);
                $att[$k] = $v;
            }
            $Variables["Attachments"] = $att;
            $pageToShow = $obj->inner_page_attachment;
        }
        else
            $pageToShow = $obj->inner_page;
    }
}

foreach ($Variables as $k=>$v) {
    if ((!is_array($v))&&(!is_object($v)))
        $Variables[$k] = strtr($v, $Language->getLang());
}


// Register Twig and load templates
require_once('lib/Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('views/kse/templates');
$twig = new Twig_Environment($loader, array(
	'cache' => 'views/default/cache',
        'auto_reload' => '1'
));

$template = $twig->loadTemplate($pageToShow);
$template->display($Variables);
?>
