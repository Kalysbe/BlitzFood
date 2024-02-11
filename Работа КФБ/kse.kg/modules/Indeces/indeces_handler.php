<?php

function calculateChange($new_val, $old_val) {
    $max_val = 0;
    $min_val = 0;
    if ($new_val == $old_val)
        return 0;


    if ($new_val > $old_val) {
        $isBetter = true;
        $max_val = $new_val;
        $min_val = $old_val;
    } else {
        $isBetter = false;
        $max_val = $old_val;
        $min_val = $new_val;
    }

    $diff = $max_val - $min_val;
    $one_prc = $max_val / 100;
    if (!$isBetter)
        $prefix = "-";
    else
        $prefix = "";
    return $prefix . round($diff / $one_prc, 2);
}

function Indeces_getModuleBuffer($id) {
	$link = MainClass::getSingleton()->getDbConnection();
    $sql = "SELECT * FROM `mod_cap_index` ORDER BY `date` DESC LIMIT 1";
    $result = mysqli_query($link, $sql);
    $kse_index = mysqli_fetch_object($result);

    $sql = "SELECT * FROM `mod_cap_index` WHERE (`date`<'" . $kse_index->date . "') ORDER BY `date` DESC LIMIT 1";
    $prev_res = mysqli_query($link, $sql);
    $prev_kse = mysqli_fetch_object($prev_res);
    $change = calculateChange($kse_index->index, $prev_kse->index);
    $color = "black";
    $symbol = "";

    if ($change < 0) {
        $image = "<img src=\"/views/kse/images/arrow_red.jpg\" />";
        $color = "red";
        $symbol = "&#9660;";
    } elseif ($change > 0) {
        $image = "<img src=\"/views/kse/images/arrow_green.jpg\" />";
        $color = "green";
        $symbol = "&#9650;";
    }
    else
        $image = " - ";

    $today = date("Y-m-d 00:00:00");
    // date change from mod_indeces to mod_cap_index
    $sql = "SELECT MAX(`date`) as `date` FROM `mod_cap_index`";

    $result = mysqli_query($link, $sql);
    $max_date = mysqli_fetch_object($result);

    $_d = build_datetime_mysql($max_date->date);
    $index_date = $_d["day"] . "." . $_d["month"] . "." . $_d["year"];

    $buffer = "
        <h2>indeces</h2>
				<table class=\"class1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                                    <tr>
                                        <th colspan=\"2\">valueson " . $index_date . "</th>
                                    </tr>
					<tr>
						<th width=\"*\"> </th>
						<th width=\"35%\"> </th>
						<th width=\"37%\">%</th>
						<!--<th width=\"14%\"> </th>-->
					</tr>
    ";
    $buffer.= "
            <tr>
                    <td><font color=\"#1464AD\">KSE</font></td>
                    <td class=\"center\">" . round($kse_index->index, 4) . "</td>
                    <td class=\"center\"><font color=\"" . $color . "\">" . $symbol . $change . "</font></td>
                    <!--<td class=\"center\">" . $image . "</td>-->
            </tr>
        ";

    $prev_sql = "SELECT MAX(`date`) as `date` FROM `mod_indeces` WHERE (`date`<'" . $max_date->date . "')";
    $prev_result = mysqli_query($link, $prev_sql);
    $prev_date = mysqli_fetch_object($prev_result);


    $sql = "SELECT * FROM `mod_indeces` WHERE (`date`>='" . $max_date->date . "') /*GROUP BY `name`*/";
    $prev_sql = "SELECT * FROM `mod_indeces` WHERE (`date`='" . $prev_date->date . "') /*GROUP BY `name`*/";
    $prev_res = mysqli_query($link, $prev_sql);
    $prev_rows = $prev_res->num_rows;
    $prev = array();
    for ($i = 0; $i < $prev_rows; $i++) {
        mysqli_data_seek($prev_res, $i);
        $prev_obj = mysqli_fetch_object($prev_res);
        $prev[$prev_obj->name] = $prev_obj->index;
    }

    $result = mysqli_query($link, $sql);
    $rows = $result->num_rows;
    for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);

        if ($obj->change > 0) {
            $image = "<img src=\"/views/kse/images/arrow_green.jpg\" />";
        } elseif ($obj->change < 0) {
            $image = "<img src=\"/views/kse/images/arrow_red.jpg\" />";
        } else {
            $image = "-";
        }

        $change = "";
        $color = "black";
        $symbol = "";
        foreach ($prev as $k=>$v) {
            if ($k == $obj->name) {
                //echo $v;
                //$change = ($obj->index - $v) * 100;
                if ($obj->index > $v) {
                    $image = "<img src=\"/views/kse/images/arrow_green.jpg\" />";
                    $color = "green";
                    $symbol = "&#9650;";
                } elseif ($obj->index < $v) {
                    $image = "<img src=\"/views/kse/images/arrow_red.jpg\" />";
                    $color = "red";
                    $symbol = "&#9660;";
                }

                $change = calculateChange($obj->index, $v);
            }
        }

        $buffer.= "
            <tr>
                    <td><font color=\"#1464AD\">" . $obj->name . "</font></td>
                    <td class=\"center\">" . $obj->index . "</td>
                    <td class=\"center\"><font color=\"" . $color . "\">" . $symbol . abs($change) . "</font></td>
                    <!--<td class=\"center\">" . $image . "</td>-->
            </tr>
        ";
    }
    

    $buffer.= "</table>";
    return $buffer;
}
?>
