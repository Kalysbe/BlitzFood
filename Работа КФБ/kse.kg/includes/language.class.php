<?php

//require_once($_SITE["%HOME%"].'/config.inc.php');

class Language {
    private $LanguageFile;
    private $LanguageName;
    private $LanguageCode;
    private $Lang;

    public function __construct($code) {
		$link = MainClass::getSingleton()->getDbConnection();
		//$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"] );
		$result = mysqli_query($link, "SELECT * FROM `languages` WHERE
		(`language_code_short`='" . $code . "')");
        $rows = $result->num_rows;

        if ($rows == 0) {
            MainClass::getSingleton()->appendError("{UnknownLanguage}");
        } else {
            $obj = $result->fetch_object();
            $this->LanguageCode = $code;
            $_SESSION["LANGUAGE"] = $this->LanguageCode;
            $this->LanguageName = $obj->language_name;
            $this->LanguageFile = $obj->language_file;
            require_once(MainClass::getSingleton()->getSiteVar("%HOME%") . "/languages/" . $this->LanguageFile);
            if (!isset($_LANG)) {
                $_SESSION["ERROR"][] = "Can't load language file";
            } else 
                $this->Lang = $_LANG;
        }
    }

    public function getLang() {
        return $this->Lang;
    }
};
