<?php
$_DB["HOST"] = "localhost";     // MySQL host
$_DB["USER"] = "ksedbadmin";    // MySQL user
$_DB["PASS"] = "kbyerc2010";    // MySQL password
$_DB["NAME"] = "kse";           // MySQL database name

$_DB["ORA_USER"] = "ts";
$_DB["ORA_PASS"] = "everytime";
$_DB["ORA_CSTRING"] = "192.168.0.26/TEST.mars.kase.kz";
$_DB["ORA_CHARSET"] = "CL8MSWIN1251";




$_SITE["%NAME%"] = "BUsiness Site Engine";          // General sitename

//print_r($_SERVER['HTTP_X_FORWARDED_PROTO']);

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'))
{
	$_SITE["%ROOT%"] = "https://www.kse.kg";                // root url	
}
else
{
	$_SITE["%ROOT%"] = "http://www.kse.kg";                // root url
}

$_SITE["%HOME%"] = "/var/www/www.kse.kg";      // home path
$_SITE["%ADMIN_EMAIL%"] = "admin@kse.kg";  // admin email
$_SITE["DEFAULT_LANGUAGE"] = "ru";                  // default language
$_SITE["MAIN_PAGE"] = "MainPage";                   // first page
$_SITE["DEBUG"] = 1;                                // change to 1 if you're
                                                    // developer
