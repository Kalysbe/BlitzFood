<?php

if (!defined('WEB_ROOT')){die ('Oops...');}

if (isset($_GET['logout']))
{
   unset($_SESSION[PORTAL.'AUTH']);
   unset($_SESSION[PORTAL.'USER']['name']);
   unset($_SESSION[PORTAL.'USER']['idfirm']);
   echo "Ñòðàíèöà çàãðóæàåòñÿ ...<script>document.location='".WEB_ROOT."'</script>";
   exit();
}

if (!isset($_SESSION[PORTAL.'AUTH']))
{
//$ip = getenv("REMOTE_ADDR");
  $ip=$_SERVER['REMOTE_ADDR'];
  if  ((substr($ip,0,9)<>"192.168.0") and (substr($ip,0,8)<>"10.0.156"))
  {
     echo "ip=".$ip;
     die ('Oops...');
  }
if (isset($_GET['auth']) && isset($_GET['uname']) && isset($_GET['uid']))
{
   @list($uname,$upass)=@split(':',safe($_GET['uname']));
   @list($p1,$p2)=@split('!',$upass);
   $uid=intval($_GET['uid']);
   if ($c = @ora_logon(OP1,OP2))
   {
      $sql_query="select name, idfirm, u_type from "
				."(select t.*, 't' u_type from ".TS.".usertrader t union all select t.*, 'c' u_type from ".TS.".userconfirmer t) t ".
				"where id=".$uid." and t.nick like '".$uname."' and passw1=".intval($p1)." and passw2=".intval($p2);
			$stmt = oci_parse($c, $sql_query);
			oci_execute($stmt);

      if (!oci_fetch($stmt))
      {die ('Please enter using KSE Trade Client...'.$sql_query);}

			$user_type=0;
			$db_user_type=oci_result($stmt,3);
			if ($db_user_type=='c')	{$user_type=4;};
			
			$_SESSION[PORTAL.'USER']['name']=oci_result($stmt,1);
			$_SESSION[PORTAL.'USER']['idfirm']=oci_result($stmt,2);
			$_SESSION[PORTAL.'AUTH']='ok';
			$_SESSION[PORTAL.'USER']['id']=$_GET['uid'];
			$_SESSION[PORTAL.'USER']['admin']=$user_type;

      echo "Ñòðàíèöà çàãðóæàåòñÿ ...<script>document.location='".WEB_ROOT."'</script>";

      echo "User: ".$uname." pass=".$upass." id=".$_GET['uid'];
      ora_logoff($c);
      exit();
   }
}
else
{
   if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['turing']))
   {

      if ($_POST['turing']!=$_SESSION['secure_code'])
      {
         echo "Îøèáêà àâòîðèçàöèè!";
         unset($_SESSION['auth']);
         exit;
      }

      $login=safe($_POST['login']);
      $password=safe($_POST['password']);
      if ($login=='admin' && $password=='nhjkm')
      {
         $_SESSION[PORTAL.'USER']['name']='Administrator';
         $_SESSION[PORTAL.'USER']['idfirm']=0;
         $_SESSION[PORTAL.'AUTH']='ok';
         $_SESSION[PORTAL.'USER']['id']=15;
         $_SESSION[PORTAL.'USER']['admin']=1;
         echo "Ñòðàíèöà çàãðóæàåòñÿ ...<script>document.location='".WEB_ROOT."'</script>";
         exit();
      }
      elseif ($login=='depo' && $password=='12depo45')       //12min45fin21
      {
         $_SESSION[PORTAL.'USER']['name']='DEPO';
         $_SESSION[PORTAL.'USER']['idfirm']=0;
         $_SESSION[PORTAL.'AUTH']='ok';
         $_SESSION[PORTAL.'USER']['id']=100;
         $_SESSION[PORTAL.'USER']['admin']=2;
         //echo "Ã?ÃµÃ®Ã¤ Ã¢ Ã±Ã¨Ã±Ã²Ã¥Ã¬Ã³...<script>document.location='".WEB_ROOT."?go=database&page=4'</script>";
         echo "Ñòðàíèöà çàãðóæàåòñÿ...<script>document.location='".WEB_ROOT."'</script>";
         exit();
      }
      elseif ($login=='minfin' && $password=='12minfin45')       //12minfin45
      {
         $_SESSION[PORTAL.'USER']['name']='DEPO';
         $_SESSION[PORTAL.'USER']['idfirm']=0;
         $_SESSION[PORTAL.'AUTH']='ok';
         $_SESSION[PORTAL.'USER']['id']=100;
         $_SESSION[PORTAL.'USER']['admin']=5;
         echo "Ñòðàíèöà çàãðóæàåòñÿ...<script>document.location='".WEB_ROOT."'</script>";
         exit();
      }
      else
      {
	  echo "Ïîêà!";
         unset($_SESSION['auth']);
         exit;
      }
   }

   echo "<html><head><link href='style10.css' type='text/css' rel='stylesheet'>
      <title>".PORTAL."</title>
      </head>
      <body>
      <table width='100%' height='100%' class='auth-content'>
      <tr>
      <td align='center' valign='middle'>
      <img src='./img/favicon.png' border='0' height='32px' align='absmiddle'>
      <font style='font-size:14px;font-weight:bold;'>Âõîä â àóêöèîí ÃÖÁ</font><br><br>
         <div style='background:#ffffff;width:300px;height:100px;'>
         <br><form method='POST' class='login-form'>
         <table>
         <tr>
         <td>
         Ëîãèí:</td><td align='right'><input type='text' name='login'></td>
         </tr>
         <tr>
         <td>
         Ïàðîëü:</td><td align='right'><input type='password' name='password'></td>
         </tr>
         <tr>
         <td colspan='2'><br><hr></td>
         </tr>
         <td>
         Ââåäèòå êîä íà êàðòèíêå:</td><td><nobr><img align='absmiddle' src='./turing/?".time()."'> <input name='turing' size='4'></nobr></td>
         </tr>
         <tr><td align='center' colspan='2'><hr><br><input class='btn-login' type='submit' value=' Âîéòè '>
         </td></tr>
         </table></form>
         <br>
         <div id='error' class='error'></div>
         </div>
      </td>
      </tr>
      </table>
      </body>
      </html>";
   exit();
}
}

?>
