<?php

require_once("../config.inc.php");
$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"] );

$query= "select ts.makedate(date0) as date1, sVolume, 
	VolCng, smark,
	to_char(sTotal,'fm999G999G990D0000', 
	'nls_numeric_characters='', ''''') as sTotal, 
	to_char(TotalCng,'fm999G999G990D00', 'nls_numeric_characters='', ''''')
	as TotalCng, to_char(sRazm,'fm999G999G990D0000', 
	'nls_numeric_characters='', ''''') as sRazm,  
	to_char(RazmCng,'fm999G999G990D00', 
	'nls_numeric_characters='', ''''') as RazmCng, 
	to_char(sSecond,'fm999G999G990D0000', 'nls_numeric_characters='', 
	''''') as sSecond,  
	to_char(SecondCng,'fm999G999G990D00', 'nls_numeric_characters='', ''''')
	as SecondCng, to_char(sList,'fm999G999G990D0000', 
	'nls_numeric_characters='', ''''') as sList,
	to_char(ListCng,'fm999G999G990D00', 
	'nls_numeric_characters='', ''''') as ListCng, 
	to_char(sUnList,'fm999G999G990D0000', 'nls_numeric_characters='', 
	''''') as sUnList,  
	to_char(UnListCng,'fm999G999G990D00', 'nls_numeric_characters='', 
	''''') as UnListCng 
	from (
		select
		date0,
		round(sum(t.volume)/2000000,1) as sVolume,
		round(www.prevvolume(t.date0),1) as VolCng,
		sum(t.PRICE / t.PRICE)/2 as sMark,
		round(sum(t.price*t.volume)/2000000,4) as sTotal,
		round(www.prevtotal(t.date0),1) as TotalCng,
		round(nvl(www.srazm(t.date0),0)/1000000,4) as sRazm,
		round(www.PREVRAZM(t.date0),1) as RazmCng,
		round(sum(t.price*t.volume)/2000000-nvl(www.srazm(t.date0),0)/1000000,4) as sSecond,
		round(www.prevsecond(t.date0),1) as SecondCng,
		round(nvl(www.slist(t.date0),0)/1000000,4) as sList,
		round(www.prevlist(t.date0),1) as ListCng,
		round(sum(t.price*t.volume)/2000000-nvl(www.slist(t.date0),0)/1000000,4) as sUnList,
		round(www.prevunlist(t.date0),1) as UnListCng
		from sys.deal2 t
		where t.date0=(select max(t1.date0) from sys.deal2 t1)
		group by t.date0)
";

    $query_ = "select * from
(
select tc.shortname as name, tc.namerus,ts.makedate(tc.zakdate),(case when ts.makedate(tc.zakdate) like '-' then '' else concat(', äàòà çàêðûòèÿ ',to_char(ts.makedate(tc.zakdate))) end) as dt,
       (select (max(ts.makeb(www.dot(round(price,2)), direct)))
       from ts.orders t where t.ownid=tc.ords_id) as b,
       (select sum(volume)
       from ts.orders t where t.ownid=tc.ords_id
       and t.price=(select max(ts.makeb(price, direct)) from ts.orders t where t.ownid=tc.ords_id)
       ) as bv,
       (select (min(ts.makes(www.dot(round(price,2)), direct)))
       from ts.orders t where t.ownid=tc.ords_id) as s,
       (select sum(volrest)
       from ts.orders t where t.ownid=tc.ords_id
       and t.price=(select min(ts.makes(price, direct)) from ts.orders t where t.ownid=tc.ords_id)
       ) as sv
  from ts.ts_currinstrument_arcts tc
 )
 where b is not null or s is not null";

    $conn = oci_connect($_DB["ORA_USER"], $_DB["ORA_PASS"], $_DB["ORA_CSTRING"], 
    $_DB["ORA_CHARSET"]);
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    	exit;
    }

    $stid = oci_parse($conn, $query);
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    	exit;
    }

    // Perform the logic of the query
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    	exit;
    }

    function FormatNum($num)
    {
            if (strlen($num) < 2)
                    return '0'.$num;
            else return $num;
    }

    $buffer = "";

    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {
	print_r($row);
	$buf = array();
        foreach ($row as $k => $item) {
            //echo $k . "====>" . $item . "<br />";
            $buf[$k] = mb_convert_encoding($item, "UTF-8", "Windows-1251");
	}
	$mydate = explode("/", $buf["DATE1"]);

	$buffer.= "
		<td class=\"center\">" . $buf["STOTAL"] . "</td>
		<td class=\"center\">" . $buf["TOTALCNG"] . "</td>
		<td class=\"center\">" . $buf["SRAZM"] . "</td>
		<td class=\"center\">" . $buf["RAZMCNG"] . "</td>
		<td class=\"center\">" . $buf["SSECOND"] . "</td>
		<td class=\"center\">" . $buf["SECONDCNG"] . "</td>
		<td class=\"center\">" . $buf["SLIST"] . "</td>
		<td class=\"center\">" . $buf["LISTCNG"] . "</td>
		<td class=\"center\">" . $buf["SUNLIST"] . "</td>
		<td class=\"center\">" . $buf["UNLISTCNG"] . "</td>
	";

	$sql = "DELETE FROM `mod_tradestat` WHERE (`day`='" . $mydate[0] . "'
		AND `month`='" . $mydate[1] . "' AND
		`year`='" . $mydate[2] . "')";
	mysqli_query($link, $sql);

	$TotalChange = 0;
	$PrimaryChange = 0;
	$SecondaryChange = 0;
	$ListingChange = 0;
	$NonListingChange = 0;

	if ($buf["TOTALCNG"] < 0)
		$TotalChange = -1;
	elseif ($buf["TOTALCNG"] > 0) 
		$TotalChange = 1;
	if ($buf["RAZMCNG"] < 0)
		$PrimaryChange = -1;
	elseif ($buf["RAZMCNG"] > 0)
		$PrimaryChange = 1;
	if ($buf["SECONDCNG"] < 0)
		$SecondaryChange = -1;
	elseif ($buf["SECONDCNG"] > 0)
		$SecondaryChange = 1;
	if ($buf["LISTCNG"] < 0)
		$ListingChange = -1;
	elseif ($buf["LISTCNG"] > 0)
		$ListingChange = 1;
	if ($buf["UNLISTCNG"] < 0) 
		$NonListingChange = -1;
	elseif ($buf["UNLISTCNG"] > 0)
		$NonListingChange = 1;

	$sql = "INSERT INTO `mod_tradestat` (
			`day`,
			`month`,
			`year`,
			`full_date`,
			`total_volume`,
			`total_volume_percent`,
			`total_volume_change`,
			`pervyi`,
			`primary_percent`,
			`primary_change`,
			`secondary`,
			`secondary_percent`,
			`secondary_change`,
			`listing`,
			`listing_percent`,
			`listing_change`,
			`non_listing`,
			`non_listing_percent`,
			`non_listing_change`
		) VALUES (
			'" . $mydate[0] . "',
			'" . $mydate[1] . "',
			'" . $mydate[2] . "',
			'" . $mydate[2] . "-" . $mydate[1] . "-"  . $mydate[0] . "',
			'" . str_replace(" ","", str_replace(",", ".", $buf["STOTAL"])) . "',
			'" . str_replace(" ","", str_replace(",", ".", $buf["TOTALCNG"])) . "',
			'" . $TotalChange . "',
			'" . str_replace(" ","", str_replace(",",".",$buf["SRAZM"])) . "',
			'" . str_replace(" ","", str_replace(",",".",$buf["RAZMCNG"])) . "',
			'" . $PrimaryChange . "',
			'" . str_replace(",",".",$buf["SSECOND"]) . "',
			'" . str_replace(" ","", str_replace(",",".",$buf["SECONDCNG"])) . "',
			'" . $SecondaryChange . "',
			'" . str_replace(" ","", str_replace(",",".",$buf["SLIST"])) . "',
			'" . str_replace(" ","", str_replace(",",".",$buf["LISTCNG"])) . "',
			'" . $ListingChange . "',
			'" . str_replace(",",".", $buf["SUNLIST"]) . "',
			'" . str_replace(" ","", str_replace(",",".",$buf["UNLISTCNG"])) . "',
			'" . $NonListingChange . "'
		)";
mysqli_query($link, $sql);
echo "<pre>" . $sql . "</pre><hr />";
        #$sql = "INSERT INTO `mod_tradestat_quatations` (`symbol`, `name`, `buy_amount`,
        #    `buy_price`, `sell_amount`, `sell_price`) VALUES ('" .
        #    $buffer["NAME"] . "', '" . $buffer["NAMERUS"] . "', 
        #    '" . $buffer["BV"] . "', '" . $buffer["B"] . "', '" .
        #    $buffer["SV"] . "', '" . $buffer["S"] . "')";
        #mysql_query($sql);
    }
	return $buffer;

    return $query;

?>
