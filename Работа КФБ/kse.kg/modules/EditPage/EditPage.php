<?php

$Module = "EditPage";

function EditPage_loadController() {
    $controller = new ControllerClass();

    if ((MainClass::getSingleton()->checkUserLogin())&&(MainClass::getSingleton()->getUserLevel() == 99)) {
        $controller->appendVariable("AdminRights", true);
		$link_mysql = MainClass::getSingleton()->getDbConnection();
		
        // Saving changes
        // Check page existence
        if (isset($_POST['doEditPage'])) {
            $query = "SELECT COUNT(*) AS `amount` FROM `pages` WHERE (`page_id`='" . $_POST["page_id"] . "')";
            $result = mysqli_query($link_mysql,$query);
            $amount = mysqli_fetch_object($result);
            if ($amount->amount != 0) {
                require_once('includes/page.class.php');
                $Page = new Page(null, $_POST["page_id"], true);
                $Page->setText($_POST["mPageText"]);
                $Page->setTitle($_POST["mPageTitle"]);
		$Page->setUname($_POST["page_uname"]);
		$Page->getId();
                $result = $Page->save();
                $controller->appendVariable("PageSaved", true);
                $controller->appendVariable("PageUname", $_POST["page_uname"]);
	if ($result) echo "1";
	else print_r($Page->save());

                foreach ($_POST as $k=>$v) {
                    if (substr($k, 0, 10) == "attachment") {
                        $sql = "SELECT * FROM `page_attachments`
                            WHERE (`page_id`='" . $Page->getId() . "' AND
                                `attachment_id`='" . $v . "') ";
                        $result = mysqli_query($link_mysql, $sql);
                        $rows = mysqli_num_rows($result);
                        if ($rows == 0) {
							echo "INSERT INTO `page_attachments` (`attachment_id`, `page_id`) VALUES ('" . $v . "', '" . $Page->getId() . "')";
                            mysqli_query($link_mysql, "
                                INSERT INTO `page_attachments` (`attachment_id`, `page_id`)
                                VALUES ('" . $v . "', '" . $Page->getId() . "')
                            ");
                        }
                    } elseif(substr($k, 0, 12) == "deattachment") {
                        mysqli_query($link_mysql, "
                            DELETE FROM `page_attachments` WHERE (`page_id`='" . $Page->getId() . "' AND
                                `attachment_id`='" . $v . "')
                                ");
                    }
                }
            }
		//print_r($_POST);
        } 
        // Load requested page
        $route = MainClass::getSingleton()->getFullUriPath();

        if ((count($route) <= 3)||(trim($route[3] == ""))) {
            Header("Location: " . MainClass::getSingleton()->getSiteVar("%ROOT%"));
            exit();
        }
        $sql = "SELECT * FROM `pages` WHERE 
            (`page_uname`='" . mysqli_real_escape_string($link_mysql, trim($route[3])) . "' AND
                `language`='" . $_SESSION["LANGUAGE"] . "')";
        $result = mysqli_query($link_mysql, $sql);
        $rows = mysqli_num_rows($result);
        if ($rows == 0) {

        } else {
            $page = mysqli_fetch_object($result);
            $mpage['page_uname'] = $page->page_uname;
            $mpage['page_title'] = $page->page_title;
            $mpage['page_text'] = $page->page_text;
            $mpage['page_id'] = $page->page_id;
            $controller->appendVariable("EditPage", $mpage);

            $sql = "SELECT * FROM `attachments`,`page_attachments` WHERE (
                `attachments`.`attachment_id`=`page_attachments`.`attachment_id`
                AND
                `page_attachments`.`page_id`='" . $page->page_id . "'
                )";
            $result = mysqli_query($link_mysql, $sql);
            $rows = mysqli_num_rows($result);
            $attachments_list = array();
            for ($i = 0; $i < $rows; $i++) {
                mysqli_data_seek($result, $i);
                $atts = mysqli_fetch_object($result);
                $attachments_list[$i]['attachment_id'] = $atts->attachment_id;
                $attachments_list[$i]['filename'] = $atts->filename;
                $attachments_list[$i]['filepath'] = $atts->filepath;
                $attachments_list[$i]['filesize'] = $atts->filesize;
                $attachments_list[$i]['name'] = $atts->name;
                $attachments_list[$i]['mime'] = $atts->mime;
                $attachments_list[$i]['cr_date'] = $atts->cr_date;
            }

            $sql = "SELECT * FROM `attachments`";
            $result = mysqli_query($link_mysql, $sql);
            $rows = mysqli_num_rows($result);
            $file_list = array();
            for ($i = 0; $i < $rows; $i++) {
                mysqli_data_seek($result, $i);
                $files = mysqli_fetch_object($result);
                $file_list[$i]['attachment_id'] = $files->attachment_id;
                $file_list[$i]['filename'] = $files->filename;
                $file_list[$i]['filepath'] = $files->filepath;
                $file_list[$i]['filesize'] = $files->filesize;
                $file_list[$i]['name'] = $files->name;
                $file_list[$i]['mime'] = $files->mime;
                $file_list[$i]['cr_date'] = $files->cr_date;
            }
            $controller->appendVariable("attachments_list", $attachments_list);
            $controller->appendVariable("file_list", $file_list);
        }
    }

    $controller->appendVariable("ControllerInclusion", "modules/Pages/EditPage.html");
    

    return $controller;
}

?>
