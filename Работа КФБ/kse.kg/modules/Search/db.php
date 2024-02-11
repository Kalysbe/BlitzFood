<?php
  class db {

    function __construct()
    {
        //$link = MainClass::getSingleton()->getDbConnection();
		//global $dbh;
        //if (!is_null($dbh)) return;
        //$dbh = mysql_pconnect('localhost', 'kseuser', 'kseuserpass');
        //mysql_select_db('kse');
        //mysql_query('SET NAMES utf8');
    }

    function select_list($query)
    {
        
		$link = MainClass::getSingleton()->getDbConnection();
		$q = mysqli_query($link, $query);
        if (!$q) return null;
        $ret = array();
        while ($row = mysqli_fetch_array($q)) {
            array_push($ret, $row);
        }
        mysqli_free_result($q);
        return $ret;
    }
  }
?>
