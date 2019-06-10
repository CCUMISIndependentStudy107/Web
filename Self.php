<?php
    include "connect_sql.php";
    include "SQLRelative.php";
    if (isset($_POST['username'])){
        $name = $_POST['username'];
        $eth = getEthernet($servername, $username, $password, $db_name, $name);
        echo $eth;

        // To split `$eth` and `#record-table` as <hr>
        // 94 分隔線分隔線分隔線分隔線分隔線的部分
        echo "8877887";

        $tablename = "record";
        $fieldname = GetFieldName($servername, $username, $password, $db_name, $tablename);
        $cardID = getCIDBYName($servername, $username, $password, $db_name, $name);
        $sql = SelectTable($tablename, $fieldname, $cardID);
        // print_r($fieldname); die();
        // [0] => ID [1] => CardID [2] => ProductID [3] => Price [4] => Quantity [5] => Time [6] => Company [7] => tx [8] => Status
        // echo $sql; die();
        // To show searching result(s)
        $OrderInfo = array();
        $fieldname_chinese = array("ID", "買方","商品名稱", "商品價格", "購買數量", "提交日期", "廠商名稱", "減碳量(g)", "狀態");
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo "<h3>竹商品購買紀錄</h3>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                for ($i = 0; $i < count($fieldname_chinese); $i++) {
                    if ($i != 0 && $i != 1) {
                        echo "<th scope='col'>" . $fieldname_chinese[$i] . "</th>";
                    }
                }
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    for ($i = 0, $j = 0; $i < count($fieldname); $i++) {
                        if ($i == count($fieldname) - 2) {
                            $txLink = "<a href='https://ropsten.etherscan.io/tx/" . $row[$fieldname[$i]] . "' target='_blank'>Tx</a>";
                            continue;
                        }
                        // if ($i == count($fieldname) - 5)
                        //     $reduceC = $row[$fieldname[$i]];
                        if ($i == count($fieldname) - 1) {
                            $id = $row[$fieldname[0]];
                            $reduceC = getReduceC($servername, $username, $password, $db_name, $id);
                            echo "<td class='reduceC'>$reduceC</td>";
                            switch ($row[$fieldname[$i]]) {
                                case 1:
                                    echo "<td><span class='text-success'>PASS(" . $txLink . ")</span></td>";
                                    break;
                                case 2:
                                    echo "<td><span class='text-danger'>FAIL</span></td>";
                                    break;
                                default:
                                    echo "<td><span class='text-warning'>PENDING</span></td>";
                                    break;
                            }
                        }
                        else {
                            // 隱藏 `id` 欄位，用以抓取買方的 wallet-Address
                            if ($i == 0) {
                                $id = $row[$fieldname[0]];
                                $eth = getEthernetBYCID($servername, $username, $password, $db_name, $id);
                                echo "<td id='record" . $id . "' style='display: none'>" . $eth . "</td>";
                            }
                            else if ($i == 7) { /* 不要顯示 `tx(7)` */ }
                            else if ($i == 5) {
                                echo "<td class='datetime' title='" . $row[$fieldname[$i]] . "'>" . $row[$fieldname[$i]] . "</td>";
                            }
                            else if ($i == 1) { /* 不必要顯示買方名稱 */ }
                            else if ($i == 2) {
                                $id = $row[$fieldname[0]];
                                $pid = $row[$fieldname[2]];
                                $name = getProductBYID($servername, $username, $password, $db_name, $id);
                                echo "<td title='" . $name . "'>" . $name . "</td>";
                            }
                            else {
                                echo "<td title='" . $row[$fieldname[$i]] . "'>" . $row[$fieldname[$i]] . "</td>";
                            }
                        }
                        $id = $row[$fieldname[0]];
                        // if ($i > 0){
                            // echo $i."--".$row[$ProductInfoName[$i]];
                            //product name = 1 company name=10
                        $OrderInfo[$id][$j++] = $row[$fieldname[$i]];
                        // }
                        // echo "<br/>";
                    }
                    echo "<td>";
                    echo "<button type='button' class='btn btn-sm btn-success' data-toggle='modal' data-target='#show-more-purchase-details-modal' onclick='showMorePurchaseDetails($pid)'>！</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                // print_r($OrderInfo);
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
                echo "<script> purchaseHistoryChart(); </script>";
                mysqli_free_result($result);
            }
            else {
                // Catch error
                echo "No records matching your query were found. \n";
            }
        }
        else {
            // Catch error
            echo "ERROR: Could not able to execute $sql " . mysqli_error($conn) . " \n";
        }

        // // Close connection
        mysqli_close($conn);
    }

    function SelectTable($tablename,$fieldname,$key) {
        $sql = "SELECT * FROM $tablename WHERE $fieldname[1] =\"$key\" ORDER BY id DESC";
        return $sql;
    }

    function getProductBYID($servername,$username,$password,$db_name,$id){
        $preprocess_table = "preprocess";
        $preprocess_fieldname = GetFieldName($servername, $username, $password, $db_name, $preprocess_table);
        $record_table = "record";
        $record_fieldname = GetFieldName($servername, $username, $password, $db_name, $record_table);
        // print_r($preprocess_fieldname); die();
        // [0] => ID [1] => Name [2] => Price [3] => Quantity [4] => Information [5] => Weight [6] => Tag [7] => PictureName [8] => ReduceC [9] => FolderName [10] => Company [11] => tx [12] => checks
        // print_r($record_fieldname);
        //[0] => ID [1] => CardID [2] => ProductID [3] => Price [4] => Quantity [5] => Time [6] => Company [7] => tx [8] => Status
        $sql = "SELECT ".$preprocess_table.".".$preprocess_fieldname[1]." FROM ".$preprocess_table.",".$record_table." WHERE ".$preprocess_table.".".$preprocess_fieldname[0]."=".$record_table.".".$record_fieldname[2]." AND ".$record_table.".".$preprocess_fieldname[0]."=".$id.";";
        // echo $sql; die();
        $conn = mysqli_connect($servername, $username, $password, $db_name);
        $name;
        if ($res = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    $name = $row[$preprocess_fieldname[1]];
                }
            }
            else {
                echo "No result!<br/>";
                return -1;
            }
            mysqli_free_result($res);
        }
        // print($name);
        return $name;
    }

    function getCIDBYName($servername,$username,$password,$db_name,$name){
        $member_table = "member";
        $member_fieldname = GetFieldName($servername, $username, $password, $db_name, $member_table);
        // print_r($member_fieldname);
        // [0] => ID [1] => name [2] => CardID [3] => Ether [4] => HDC
        $sql = "SELECT ".$member_fieldname[2]." FROM ".$member_table." WHERE ".$member_fieldname[1]."=\"".$name."\";";
        // echo $sql; die();
        $conn = mysqli_connect($servername, $username, $password, $db_name);
        $cid;
        if ($res = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    $cid = $row[$member_fieldname[2]];
                }
            }
            else {
                echo "No result!<br/>";
                return -1;
            }
            mysqli_free_result($res);
        }
        // print($cid);
        return $cid;
    }

    function getEthernetBYCID($servername,$username,$password,$db_name,$id){
        $member_table = "member";
        $member_fieldname = GetFieldName($servername, $username, $password, $db_name, $member_table);
        $record_table = "record";
        $record_fieldname = GetFieldName($servername, $username, $password, $db_name, $record_table);
        // print_r($member_fieldname);
        //[0] => ID [1] => name [2] => CardID [3] => Ether [4] => HDC
        // print_r($record_fieldname);
        //[0] => ID [1] => CardID [2] => ProductID [3] => Price [4] => Quantity [5] => Time [6] => Company [7] => Status
        $sql = "SELECT ".$member_table.".".$member_fieldname[3]." FROM ".$member_table.",".$record_table." WHERE ".$member_table.".".$member_fieldname[2]."=".$record_table.".".$record_fieldname[1]." AND ".$record_table.".".$member_fieldname[0]."=".$id.";";
        // echo $sql;
        $conn = mysqli_connect($servername, $username, $password, $db_name);
        $eth;
        if ($res = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    $eth = $row[$member_fieldname[3]];
                }
            }
            else {
                echo "No result!<br/>";
                return -1;
            }
            mysqli_free_result($res);
        }
        // print($eth);
        return $eth;
    }

    function getReduceC($servername,$username,$password,$db_name,$id){
        $record_table = "record";
        $record_fieldname = GetFieldName($servername, $username, $password, $db_name,$record_table);
        // print_r($record_fieldname);
        //[0] => ID [1] => CardID [2] => ProductID [3] => Price [4] => Quantity [5] => Time [6] => Company [7] => Status
        $preprocess_table = "preprocess";
        $preprocess_fieldname = GetFieldName($servername, $username, $password, $db_name,$preprocess_table);
        // print_r($preprocess_fieldname);
        //[0] => ID [1] => Name [2] => Price [3] => Quantity [4] => Information [5] => Weight [6] => Tag [7] => PictureName [8] => ReduceC [9] => FolderName [10] => Company [11] => tx [12] => checks
        $sql = "SELECT ".$record_fieldname[4]." FROM ".$record_table." WHERE ".$record_fieldname[0]."=".$id.";";
        // echo $sql;
        $conn = mysqli_connect($servername, $username, $password, $db_name);
        $quantity;
        $weight;
        if ($res = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    $quantity = $row[$record_fieldname[4]];
                }
            }
            else {
                echo "No result for quantity!<br/>";
                return ;
            }
            mysqli_free_result($res);
        }
        // echo "Q=".$quantity."<br/>";
        $sql = "SELECT ".$preprocess_fieldname[5]." FROM ".$record_table.",".$preprocess_table." WHERE ".$record_table.".".$record_fieldname[2]."=".$preprocess_table.".".$preprocess_fieldname[0]." AND ".$record_table.".".$record_fieldname[0]."=".$id.";";
        // echo $sql;
        if ($res = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    $weight = $row[$preprocess_fieldname[5]];
                }
            }
            else {
                echo "No result for weight!<br/>";
                return ;
            }
            mysqli_free_result($res);
        }
        // echo $weight;
        // echo "W = ".$weight." Q = ".$quantity;
        $reduce = (float)$quantity*$weight*0.44;
        return $reduce;
    }

    function getEthernet($servername,$username,$password,$db_name,$name){
        $member_table = "member";
        $member_fieldname = GetFieldName($servername, $username, $password, $db_name, $member_table);
        // print_r($member_fieldname);
        //[0] => ID [1] => name [2] => CardID [3] => Ether [4] => HDC
        $sql = "SELECT ".$member_table.".".$member_fieldname[3]." FROM ".$member_table." WHERE ".$member_table.".".$member_fieldname[1]."=\"".$name."\";";
        // echo $sql;
        $conn = mysqli_connect($servername, $username, $password, $db_name);
        $eth;
        if ($res = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    $eth = $row[$member_fieldname[3]];
                }
            }
            else {
                echo "No result!<br/>";
                return ;
            }
            mysqli_free_result($res);
        }
        // print($eth);
        return $eth;
    }
?>