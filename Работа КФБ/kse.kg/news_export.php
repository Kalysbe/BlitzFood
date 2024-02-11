<?php

$table = "Blog_Entries";

require_once("./config.inc.php");

mysql_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"]);
mysql_select_db($_DB["NAME"]);
mysql_query("SET NAMES 'utf8'");

$query = "SELECT * FROM ls.sitenews";

$conn = oci_connect($_DB["ORA_USER"], $_DB["ORA_PASS"], $_DB["ORA_CSTRING"], $_DB["ORA_CHARSET"]);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, $query);
if (!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Perform the logic of the query
$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

function FormatNum($num)
{
	if (strlen($num) < 2)
		return '0'.$num;
	else return $num;
}



//print "<table border='1'>\n";
$temporary_data = array();
$i = 1;
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {
    //print "<tr>\n";
    //print ("Processing <b>" . $i . "</b><br />");
    $i++;
    $tmp = array();
    foreach ($row as $k => $item) {
        // IF the field is Date
        if ($k == "DATE0")
        {
            $date = FormatNum(intval($item & 255)) . "-" . FormatNum(intval($item / 256 & 255)) . "-" . intval($item / 65536);
            $tmp["date"] = intval($item / 65536) . "-" . FormatNum(intval($item / 256 & 255)) . "-" . FormatNum(intval($item & 255));
            //print "<td>[" . $k . "] " . $date . "</td>";
        }
        else if ($k == "TITLE")
        {
            if ($item != "")
            {
                $tmp["title"] = $item;

            }
        }
        else if ($k == "BODY")
        {
            if ($item != "")
            {
                $tmp["body"] = $item;
                $tmp["langcode"] = "ru";
            }
        }
        else if ($k == "TITLE_E")
        {
            if ($item != "")
            {
                $tmp["title"] = $item;
            }
        }
        else if ($k == "BODY_E")
        {
            if ($item != "")
            {
                $tmp["body"] = $item;
                $tmp["langcode"] = "en";
            }
        }
        else if ($k == "STATUS1")
        {
            $tmp["flag"] = $item;
        }
        
        //print "<td>[" . $k . "] " . $item . "</td>";
    }
    $temporary_data[] = $tmp;
    //print "</tr>\n";
}
//print "</table>\n";

function win2utf($s)
{
    return $s;
   for($i=0, $m=strlen($s); $i<$m; $i++)
   {
       $c=ord($s[$i]);
       if ($c<=127) {$t.=chr($c); continue; }
       if ($c>=192 && $c<=207)    {$t.=chr(208).chr($c-48); continue; }
       if ($c>=208 && $c<=239) {$t.=chr(208).chr($c-48); continue; }
       if ($c>=240 && $c<=255) {$t.=chr(209).chr($c-112); continue; }
       if ($c==184) { $t.=chr(209).chr(209); continue; };
   if ($c==168) { $t.=chr(208).chr(129);  continue; };
   }
   return $t;
}

require_once("mainfile.php");
echo "<html xml:lang=\"en\" lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"content-type\" content=\"text/html; charset=windows-1251\" />
</head>
";
foreach ($temporary_data as $k=>$v)
{
    //$result = mysql_query("SELECT `news_id` FROM `" . $table . "` WHERE
    //        (`date`='" . $v["date"] . "' AND `title`='" . $v["title"] . "')");
    if ($rows == 0)
    {
        //$title = win2utf(mysql_real_escape_string($v["title"]));
        //$title = mysql_real_escape_string($v["title"]);
        $title = $v["title"];
        echo $title . "<br />";
        $title = mb_convert_encoding($title, "UTF8", "Windows-1251");
        $title = strip_tags($title);
        $title = htmlspecialchars($title,ENT_QUOTES);
        $title = addslashes($title);
        $utitle = strtr($title, $Translit);

        $text = mb_convert_encoding($v["body"], "UTF8", "Windows-1251");

        $symbols = array
        (
            " " => "-",
            "," => "",
            "." => "",
            //"\"" => "",
            //"\'" => "",
            "?" => "",
            "!" => "",
	    "~" => "",
	    "&laquo;"=>"",
	    "&raquo;"=>"",
	    //,
            //"\\" => "",
            //"/" => ""
        );
        $utitle = strtr($utitle, $symbols);
        /*mysql_query("INSERT INTO `" . $table . "` (`title`, `text`, `date`, `flag`, `lang_code`)
        VALUES ('" . $title . "', '" . win2utf(mysql_real_escape_string($v["body"])) . "', '" . $v["date"] . "',
        '" . $v["flag"] . "', '" . $v["langcode"] . "')");*/
        //print $utitle . "<br />";
        if ($v["langcode"] == "ru")
        {
            mysql_query("INSERT INTO `" . $table . "` (`blog_id`, `name`, `title`, `text`,
            `cr_date`, `status`) VALUES ('1', '" . $utitle . "', '" . $title . "',
            '" . $text . "', '" . $v["date"] . "', '1')");
        }
        if (mysql_error() != "")
            echo "<pre>" . mysql_error() . "</pre>";
    }
}
echo "</html>";

oci_free_statement($stid);
oci_close($conn);


?>
