<?php

error_reporting(0);

   include ('./core/conf.php');
   include ('./core/auth.php');
   include ('./core/auction_status.php');

   header('Content-Type: text/html; charset=windows-1251');


   //Ajax requests

   if (isset($_GET['op']) && isset($_GET['action']))
   {
      switch ($_GET['action'])
      {
         case 'add_lot':
         {
            include('./core/admin_issue_ajax.php');
            break;
         }
         case 'add_order':
         {
            include('./core/user_orders_ajax.php');
            break;
         }
         case 'show_issue_prop':
         {
            include('./core/issue_prop_ajax.php');
            break;
         }		 
         case 'status':
         {
            include('./core/auction_options_ajax.php');
            break;
         }
         case 'deals':
         {
            include('./core/user_deals.php');
            break;
         }
         case 'orders':
         {
            include('./core/admin_orders_ajax.php');
            break;
         }
         case 'report_options':
         {
            include('./core/admin_report_options.php');
            break;
         }
         case 'user_report_options':
         {
            include('./core/user_reports_options.php');
            break;
         }
      }
      exit();
   }


//$act='';
//echo('$_GET[act]='.$_GET['act']);
//echo('$_POST[act]='.$_POST['act']);
//$post_string = implode($_POST);
//echo('$post_string='.$post_string);

if (isset($_GET['act']))
{
   $act=$_GET['act'];
}
if (isset($_POST['act']))
{
   $act=$_POST['act'];
}

?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
<html><head>
<title><?php echo PORTAL.' - ['.$_SESSION[PORTAL.'USER']['name'].': '.date('d.m.Y').']'; ?></title
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251">
<meta name="cache-control" content="no-cache">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv='generator' content='Nicky'>
<meta http-equiv='author' content='m@[tador]'>
<link href='stylenew.css' id="css" type='text/css' rel='stylesheet'>
<link href='print.css' media='print' id="css_print" type='text/css' rel='stylesheet'>
<script defer type='text/javascript' src='./js/scriptnew.js' ></script>
<script defer type='text/javascript' src='./calendar/src/script.js'></script>
</head>
<body>
<?php

if (isset($_SESSION[PORTAL.'USER']['admin']) && $_SESSION[PORTAL.'USER']['admin']!=0){
	 if ($_SESSION[PORTAL.'USER']['admin']==4){ //��������������
		include ('./core/confirmer.php');
   }   
	 if ($_SESSION[PORTAL.'USER']['admin']==2){ //������
     //echo "111";
     include ('./core/minfin.php');
   }
   if ($_SESSION[PORTAL.'USER']['admin']==1){ //������
      //echo "111";
      include ('./core/new_minfin.php');
    }
   if ($_SESSION[PORTAL.'USER']['admin']==1){ //������������� ������
     include ('./core/admin.php');
   }
}
else{
	 include ('./core/user.php');
}
?>
</body>
</html>