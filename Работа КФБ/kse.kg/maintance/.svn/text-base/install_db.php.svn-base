<?php

require_once("../config.inc.php");
require_once("../mainfile.php");

$f = fopen("./install.sql", "r");
$buffer = fread($f, filesize("./install.sql"));
fclose($f);
$queries = explode(";", $buffer);

foreach ($queries as $query) {
    if (!mysql_query($query)) {
        echo mysql_error() . "<br />";
    }
}

?>
