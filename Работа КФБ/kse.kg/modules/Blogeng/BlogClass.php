<?php


class BlogClass {
    private $blog_id;
    private $blog_name;
    private $blog_title;

    public function __construct($id = 0, $name = "") {
        if (($id == 0)&&($name == "")) {
            MainClass::getSingleton()->appendError("{NoBlogError}");
            return;
        }
        $this->blog_id = $id;
        $this->blog_name = $name;
        if ($this->blog_id != 0) {
            $cause = "`blog_id`='" . $this->blog_id . "'";
        } else {
            $cause = "`blog_name`='" . $this->blog_name . "'";
        }
        $sql = "SELECT * FROM `Blogs` WHERE (" . $cause . ")";
        $result = mysql_query($sql);
        $rows = mysql_num_rows($result);
        if ($rows == 0) {
            MainClass::getSingleton()->appendError("{NoBlogError}");
            return;
        }
        $obj = mysql_fetch_object($result);

        $this->blog_id = $obj->blog_id;
        $this->blog_name = $obj->blog_name;
        $this->blog_title = $obj->blog_title;
    }

    public function get_blog_id() {
        return $this->blog_id;
    }

    public function get_blog_name() {
        return $this->blog_name;
    }

    public function get_blog_title() {
        return $this->blog_title;
    }

};
