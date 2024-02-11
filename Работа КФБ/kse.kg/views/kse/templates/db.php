<?php
  class db {

    function __construct()
    {
        global $dbh;
        if (!is_null($dbh)) return;
        $dbh = mysqli_connect('localhost', 'kseuser', 'kseuserpass', 'kse');
        mysqli_query($dbh, 'SET NAMES utf8');
    }

    function select_list($query)
    {
        $dbh = mysqli_connect('localhost', 'kseuser', 'kseuserpass', 'kse');
		$q = mysqli_query($dbh, $query);
        if (!$q) return null;
        $ret = array();
        while ($row = mysqli_fetch_array($q, MYSQL_ASSOC)) {
            array_push($ret, $row);
        }
        mysqli_free_result($q);
        return $ret;
    }
  }
?>
