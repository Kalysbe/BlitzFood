<?php
$date=date('d.m.Y');
if (isset($_GET['txtDate']))
{$date=$_GET['txtDate'];}
if (isset($_POST['txtDate']))
{$date=$_POST['txtDate'];}
?>

<link rel="stylesheet" href="./calendar/src/style.css" media="screen">
<SCRIPT type="text/javascript" src="./calendar/src/script.js"></script>
<input type="text" value="<?php echo $date; ?>" readonly name="txtDate"><input type="button" value="..." onclick="displayCalendar(document.all.txtDate,'dd.mm.yyyy',this)">
