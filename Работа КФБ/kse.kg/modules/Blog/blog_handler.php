<?php

function flipdate($dt, $seperator_in = '-', $seperator_out = '-')
{
    return implode($seperator_out, array_reverse(explode($seperator_in, $dt)));
}

function Blog_getModuleBuffer($id) {
	$link = MainClass::getSingleton()->getDbConnection();
    $sql = "SELECT * FROM `modules_parameters` WHERE (`mappid`='" . $id . "')";
    $result = mysqli_query($link, $sql);
    $rows = $result->num_rows;

    $Parameters = array(
        "Name" => "",
        "ItemsOnPage" => 10,
        "DisplayContent" => "1",
        "ContentLength" => "200",
        "DisplayContentLength" => "",
        "DisplayTitles" => "1",
        "TitleAsLink" => "1",
        "DisplayDate" => "1",
        "RSS" => "1"
    );

    for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
        switch ($obj->name) {
            case "Name":
                $Parameters["Name"] = $obj->value;
                break;
            case "ItemsOnPage":
                $Parameters["ItemsOnPage"] = $obj->value;
                break;
            case "ContentLength":
                $Parameters["ContentLength"] = $obj->value;
                break;

        }
    }

    if ($Parameters["Name"] == "") {
        MainClass::getSingleton()->appendError("{BadModuleParameters}");
        return "";
    }

    $buffer = "<div id=\"blog_module\" class=\"blog_module\">";

    $sql = "SELECT * FROM `Blogs` WHERE (`blog_name`='" . $Parameters["Name"] . "')";
    $result = mysqli_query($link, $sql);
    $rows = $result->num_rows;
    if ($rows == 0) {
        $buffer.= "<h3>{BlogWasNotFound}</h3>";
        $buffer.= "<div class=\"error ui-corner-all\">{BlogWasNotFoundDescription}</div>";
        if (MainClass::getSingleton()->checkUserLogin()) {
            if (MainClass::getSingleton()->getUserLevel() == 99) {
                $buffer.= "<div>
                    <h3>{DoCreateBlog}</h3>
                    <form action=\"" . MainClass::getSingleton()->getSiteVar("%ROOT%") . "/modules/Blog/BlogControl.php\" method=\"POST\">
                    <div id=\"two_columns\">
                        <label>{BlogName}:</label>
                        <p><input type=\"text\" name=\"mBlogTitle\" value=\"\" class=\"ui-corner-all\" /></p>
                        <div class=\"clean\"></div>
                        <label>&nbsp;</label>
                        <p><input type=\"submit\" name=\"doCreateBlog\" value=\"{doCreateBlog}\" /></p>
                        <div class=\"clean\"></div>
                        <input type=\"hidden\" name=\"mBlogUname\" value=\"" . $Parameters["Name"] . "\" />
                        <input type=\"hidden\" name=\"return\" value=\"" . $_SERVER["REQUEST_URI"] . "\" />
                    </div>
                    </form>
                </div>";
            }
        }
    } else {
        $Blog = mysqli_fetch_object($result);
        $sql = "SELECT * FROM `Blog_Entries` WHERE (`blog_id`='" . $Blog->blog_id . "') ORDER BY `cr_date` DESC LIMIT " . $Parameters["ItemsOnPage"];
        $result = mysqli_query($link, $sql);
        $rows = $result->num_rows;
        for ($i = 0; $i < $rows; $i++) {
            mysqli_data_seek($result, $i);
            $Entry = mysqli_fetch_object($result);
            $tmp_date = build_datetime_mysql($Entry->cr_date);
            $local_date = $tmp_date['day'] . "." . $tmp_date['month'] . "." . $tmp_date['year'];
            $buffer.= "
                
                <div class=\"blog_title\"><strong>" . $local_date . "</strong>
                    <a href=\"" .
                    MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" .
                    $_SESSION["LANGUAGE"] . "/" . $Blog->blog_name . "/" .
                    $Entry->blogentry_id . "/" . $Entry->name . "\">" .
                    $Entry->title . "
                    </a>
                </div>
                <div class=\"blog_text\">";
            if (isset($Parameters["ContentLength"])) {
                $buffer.= substr(strip_tags($Entry->text), 0, $Parameters["ContentLength"]);
                $buffer.= "...";
            } else
                $buffer.= strip_tags($Entry->text);

            $buffer.= "</div>
                
            ";
        }

        $blog_link = MainClass::getSingleton()->getSiteVar("%ROOT%") . "/";
        $blog_link.= $_SESSION["LANGUAGE"] . "/" . $Blog->blog_name;

        $buffer.= "<div class=\"button\" style=\"text-align: right; margin-top: 10px;\">
            <a href=\"" . $blog_link . "/\">  {AllNews} </a>
        </div>";

        if (MainClass::getSingleton()->checkUserLogin()) {
            if (MainClass::getSingleton()->getUserLevel() == 99) {
                $buffer.= "<a href=\"" .
                MainClass::getSingleton()->getSiteVar("%ROOT%") .
                "/" . MainClass::getSingleton()->getLanguageCode() . "/" . $Blog->blog_name . "/ControlPanel\" class=\"buse_cp_link ui-corner-all\">{BlogControlPanel}</a>";
            }
        }
    }


    $buffer.= "</div>";
    return $buffer;
}

?>
