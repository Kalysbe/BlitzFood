<?php 
$bibl_ext = dirname ($_SERVER['SCRIPT_FILENAME']).'/extensions/php_gd.dll'; 
if (! extension_loaded ('gd') and @is_file ($bibl_ext)){ dl ("extensions/php_gd.dll");} 
if (! extension_loaded ('gd')){ print "��� ����� ���������� $bibl_ext";} 
else{print "���� GD ���������� $bibl_ext ���������.";} 
?>