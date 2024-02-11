<?php

session_start();

@set_time_limit(0);
@ini_set('max_execution_time',0);
Error_Reporting(-1);

define('WEB_ROOT','https://'.$_SERVER['SERVER_NAME'].'/');

define('PORTAL','KSE - Аукцион ГЦБ');

define('ROWS',10);
define('NamCost',100);  //Наминальная стоимость одной ГКВ

//mars
//define('SRV','worldm');
//define('TS','tsm');

//sun
define('SRV','worldm');
define('TS','ts');

define('OP1','www@'.SRV);
define('OP2','www');

function sel($arg,$dt,$id){

  $sql="update ls.auction_issue set volume=".$arg.", tot=".$arg." where curr_id=".$id." and date0=".$dt;
	 if ($c = ora_logon("ls@".SRV,"ls"))
   {
	  $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }
   
   $sql="update ls.auction_orders set status=0 where curr_id=".$id." and date0=".$dt;
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
      $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }

   $sql="delete from ls.auction_deals where curr_id=".$id." and status=0 and date0=".$dt;
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
      $stmt = oci_parse($c, $sql); 
	  $res=oci_execute($stmt);
   }

   $sql="begin ".$_SESSION['TYPE']."; end;";
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
      $stmt = oci_parse($c, $sql); 
	  $res=oci_execute($stmt);
   }
}
function safe($str)
{
   $str=str_replace("'",'`',htmlspecialchars($str));
   return $str;
}

function code($strData, $key)
{
   $strTmp='';
   for ($i=0; $i<strlen($strData);$i++)
   {
      $a=substr($strData,$i,1);
      $strTmp .= (ord($a) - $key) . "A";
   }
   return $strTmp;
}

function atype($type)
{
   $res='';
   switch ($type)
   {
      case 'ls.auction_NBKR_GKV': {$res='Простой аукцион'; break;}
	  case 'ls.auction_NBKR_GKO5': {$res='Аукцион НБКР по ГКО5'; break;}
      //default: $res='Аукцион НБКР по ГКО5';
   }
   return $res;
}

function decode($strData, $key)
{
   for ($i=0; $i<strlen($strData);$i++)
   {
      $ch=substr($strData,$i,1);
      if ($ch=="A")
      {
         $strTmp=$strTmp . chr($tmp + $key);
         $tmp="";
      }
      else
      {
         $tmp=$tmp . $ch;
      }
   }
   return $strTmp;
}

function getInstrumentProp($curr_id)
{
	//echo hhh.$curr_id;
	$data = array();
	$sql = "select 
				t.settlement_date, 
				t.repayment_date, 
				t.coupon_annual_rate, 
				t.amount_ratio, 
				t.freq_payments 
			from ls.auction_issue t 
			where 
				date0=(select max(date0) from ls.auction_issue where t.curr_id=".$curr_id." ) 
				and t.curr_id=".$curr_id;
	
	if ($c = ora_logon("ls@".SRV,"ls"))
    {
		$stmt = oci_parse($c, $sql); 
		oci_execute($stmt);
		
		while (oci_fetch($stmt)){;
		$data = array(
			'settlement_date_l' => oci_result($stmt, 1), 
			'repayment_date_l' => oci_result($stmt, 2), 
			'settlement_date' => MakeDate(oci_result($stmt, 1)), 
			'repayment_date' => MakeDate(oci_result($stmt, 2)), 
			'coupon_annual_rate' => oci_result($stmt, 3),  
			'amount_ratio' => oci_result($stmt, 4),  
			'freq_payments' => oci_result($stmt, 5)
		);
		}
	};
	
	return $data;
}


function MakeDate($iDate)
{
   if ($iDate==0){$strTmp='';}
   else
   {
   $strTmp=FormatNum(intval($iDate & 255)) .
         '/' . FormatNum(intval($iDate / 256 & 255)) .
         '/' . intval($iDate / 65536);
   }
   return $strTmp;
}

function MakeTime($iTime)
{
   // 00:00
   if ($iTime==0){$strTmp='00:00';}
   else
   {
   $strTmp=FormatNum(intval($iTime / 65536)).
      ':'.FormatNum(intval($iTime / 256 & 255));
   }
   return $strTmp;
}

function MakeTimeFull($iTime)
{
   // 00:00:00
   if ($iTime==0){$strTmp='00:00:00';}
   else
   {
   $strTmp=FormatNum(intval($iTime / 65536)).
      ':'.FormatNum(intval($iTime / 256 & 255)).
      ':'.FormatNum(intval($iTime & 255));
   }
   return $strTmp;
}


function MakeLongDate($sDate)
{
   list($d, $m, $y) = split('[/.-]', $sDate);
   $strTmp=$y * 65536 + $m * 256 + $d;
   return $strTmp;
}

function MakeLongTime($sTime)
{
   list($h, $m, $s) = split(':', $sTime);
   $strTmp=$h * 65536 + $m * 256 + $s;
   return $strTmp;
}

function MakeMysqlDate($sDate)
{

   //list($m, $d, $y) = split('[/.-]', $sDate);
   list($m, $d, $y) = split('[/.-]', $sDate);
   return date('Y/m/d',strtotime($m . '/' . $d . '/' . $y)) ;
}

function FormatNum($num)
{
   if (strlen($num)<2)
   {
      return '0'.$num;
   }
   else return $num;
}

function MakeBoolYesNo($num)
{
   if ($num==0)
   {
      return 'Нет';
   }
   else return 'Да';
}

function MakeT($sname)
{
   //TB01042007
   //1/9-07
   //$res=substr($sname,-4,1);
   $res=intval(substr($sname,-4,1))*30+(intval(substr($sname,-4,1))/3);
   return $res;
}

function ora_logon($usuario, $password) 
{ 
    $user_login=explode('@',$usuario);
#    echo 'auth - '.$user_login[0].' pas - '.$password. ' SRV - '.SRV;
    $conn = oci_connect($user_login[0],$password, SRV);
#    $conn = oci_connect('www1','www1', 'worldm');    
    if (!$conn)
    {
        $e = oci_error();
        echo $e['message'];
    }
    return $conn; 
} 
function Ora_Do($conn, $consulta) { 

    //echo 'query-'.$consulta;
    $stmt = oci_parse($conn, $consulta); 
	oci_execute($stmt);
	$nrows = oci_fetch_all($stmt, $results);
	//echo '$nrows-'.$nrows;
	return $results;
}

function Ora_Open($conexion) { 
        $cursor[0]=$conexion; 
        return $cursor; 
} 

function Ora_Parse(&$cursor, $consulta) { 
        $cursor[1]=oci_parse($cursor[0],$consulta); 
        return $cursor; 
} 

function Ora_Exec(&$cursor) { 
        oci_execute($cursor[1]); 
        $cursor[2]=1; 
        return $cursor; 
} 

function Ora_Fetch(&$cursor) 
{ 
        if ($cursor[2] == 1) $cursor[2]=0; 
        return oci_fetch($cursor[1]); 
} 

function Ora_GetColumn(&$cursor, $indice) 
{ 
        if ($cursor[2] == 1) { 
                Ora_Fetch($cursor); 
                $cursor[2]=0; 
        } 
        $valor = oci_result($cursor[1],$indice+1); 
        return $valor; 
} 

function Ora_Close(&$cursor) 
{ 
        unset($cursor[1]); 
} 

function Ora_Logoff($conexion) { 
} 

?>

