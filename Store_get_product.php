<?php
    include "connect_sql.php";
    include "SQLRelative.php";
    if (isset($_POST["CompanyName"])) {
        $companyName = $_POST["CompanyName"];
        // $tablename = "product";
        $tablename = "preprocess";
        $fieldName = GetFieldName($servername, $username, $password, $db_name, $tablename);
        FetchSQL($servername, $username, $password, $db_name, $tablename, $fieldName, $companyName);
    }

    function FetchSQL($servername, $username, $password, $db_name, $tablename, $fieldName, $companyName) {
        // print_r($fieldName);
        //[0] => ID [1] => Name [2] => Price [3] => Quantity [4] => Information [5] => Weight [6] => Tag
        //[7] => PictureName [8] => ReduceC [9] => FolderName [10] => Company [11] => tx [12] => checks
        $conn = mysqli_connect($servername, $username, $password, $db_name);
        if (!$conn)
            die("Connection failed: " . mysqli_connect_error() . "<br/>");
        if ($companyName == "")
            $sql = "SELECT * FROM $tablename WHERE $fieldName[12] = 1";
        else
            $sql = "SELECT * FROM $tablename WHERE $fieldName[10] LIKE %\"$companyName\"% AND $fieldName[12] = 1";
        if ($conn -> query($sql) == false) {
            echo "There is no result where company = $companyName<br/>";
        }
        else {
            $fieldnum = count($fieldName);
            if ($res = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_array($res)) {
                        for ($i = 0, $j = 0; $i < $fieldnum; $i++) {
                        // echo "<td>" . $row[$fieldname[$i]] . "</td><br/>";
                            $id = $row[$fieldName[0]];
                            $arr[$id][$j++] = $row[$fieldName[$i]];
                        }
                    }
                }
                else {
                    echo "No result!<br/>";
                    return ;
                }
                mysqli_free_result($res);
            }
            $keys = array_keys($arr);
            $productinfo = array();
            // print_r($keys);


            $result = "<div class=\"container-fluid\"><div class=\"row\">";
            $modals = "";

            for ($i = 0; $i < count($keys); $i++) {
                $path = "uploads/";
                $imgUrl = $path . $arr[$keys[$i]][9] . "/" . $arr[$keys[$i]][7];
                $result .= "<div class=\"col-sm-6 col-md-4 col-lg-3\"><div class=\"card text-center mx-1 my-3\" data-toggle=\"modal\" data-target=\"#productDetailModal$i\"><img class=\"card-img-top border-bottom\" src=\"$imgUrl\" alt=\"Success Upload product$i\"><div class=\"card-body\"><h5 class=\"card-title\">".$arr[$keys[$i]][1]."</h5></div><div class=\"card-footer text-muted\">節碳 ".$arr[$keys[$i]][8]." 克</div></div></div>";

                $modals .= "<div class=\"modal fade\" id=\"productDetailModal$i\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"productDetailModalTitle$i\" aria-hidden=\"true\"><div class=\"modal-dialog modal-xl modal-dialog-centered\" role=\"document\"><div class=\"modal-content\"><div class=\"modal-header\"><h5 class=\"modal-title\">更多資訊</h5><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div><div class=\"modal-body\"><form><div class=\"form-group row\"><label for=\"name$i\" class=\"col-sm-1 col-form-label\">名稱</label><div class=\"col-sm-3\"><input type=\"text\" readonly class=\"form-control-plaintext\" id=\"name$i\" value=\"".$arr[$keys[$i]][1]."\"></div><label for=\"tag$i\" class=\"col-sm-1 col-form-label\">標籤</label><div class=\"col-sm-3\"><input type=\"text\" readonly class=\"form-control-plaintext\" id=\"tag$i\" value=\"".$arr[$keys[$i]][6]."\"></div><label for=\"reduceC$i\" class=\"col-sm-1 col-form-label\">節碳量</label><div class=\"col-sm-3\"><input type=\"text\" readonly class=\"form-control-plaintext\" id=\"reduceC$i\" value=\"".$arr[$keys[$i]][8]." 克\"></div><label for=\"price$i\" class=\"col-sm-1 col-form-label\">單價</label><div class=\"col-sm-3\"><input type=\"text\" readonly class=\"form-control-plaintext\" id=\"price$i\" value=\"".$arr[$keys[$i]][2]." 元\"></div><label for=\"quantity$i\" class=\"col-sm-1 col-form-label\">數量</label><div class=\"col-sm-3\"><input type=\"text\" readonly class=\"form-control-plaintext\" id=\"quantity$i\" value=\"".$arr[$keys[$i]][3]."\"></div><label for=\"weight$i\" class=\"col-sm-1 col-form-label\">重量</label><div class=\"col-sm-3\"><input type=\"text\" readonly class=\"form-control-plaintext\" id=\"weight$i\" value=\"".$arr[$keys[$i]][5]." 克\"></div><label for=\"information$i\" class=\"col-sm-1 col-form-label\">資訊</label><div class=\"col-sm-11\"><textarea readonly class=\"form-control-plaintext\" id=\"information$i\">".$arr[$keys[$i]][4]."</textarea></div></div></form></div><div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button></div></div></div></div>";

                // echo "<div><button type=\"button\"><img src=\"".$path.$arr[$keys[$i]][9]."/".$arr[$keys[$i]][7]."\">".$arr[$keys[$i]][1]."</button></div>";  //print 1=name 9=folder 7=pic
                array_push($productinfo,GetProductInfo($servername,$username,$password,$db_name,$tablename,$arr[$keys[$i]][0]));
            }

            $result .= "</div></div>";

            echo $result;
            echo $modals;

            // print_r($productinfo);
            //[0] => [0~12] see upside [1] => [0~12] ......
            /*e.g.
            first name = $productinfo[0][1]
            second tag = $productinfo[1][6]*/
        }
    }
?>