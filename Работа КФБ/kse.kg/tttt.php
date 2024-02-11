<?php 
$bibl_ext = dirname ($_SERVER['SCRIPT_FILENAME']).'/extensions/php_gd.dll'; 
if (! extension_loaded ('gd') and @is_file ($bibl_ext)){ dl ("extensions/php_gd.dll");} 
if (! extension_loaded ('gd')){ print "Нет файла библиотеки $bibl_ext";} 
else{print "файл GD библиотеки $bibl_ext подключен.";} 
?>