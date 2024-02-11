<?php

class User {
    private $Id;
    private $Username;
    private $Email;

    public function __construct($uid) {
		$link = MainClass::getSingleton()->getDbConnection();
        $sql = "SELECT * FROM `users` WHERE (`uid`='" . $uid . "')";
        $result = mysqli_query($link, $sql);
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $obj = mysqli_fetch_object($result);
            $this->Id = $uid;
            $this->Username = $obj->login;
            $this->Email = $obj->email;
        }
    }

    public function getUsername() {
        return $this->Username;
    }

    public function getEmail() {
        return $this->getEmail();
    }
};