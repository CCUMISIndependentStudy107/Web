<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>訂單</title>
        <script src="https://code.jquery.com/jquery-3.4.0.js" integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <script src="./web3.min.js"></script>
        <script src="./blockchain.js"></script>
        <style>
            .table td, .table th {
                padding: .75rem;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
                max-width: 160px;
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
            }

            .badge {
                margin: 0 2px;
                cursor: pointer;
                user-select: none;
            }
        </style>
    </head>
    <body>
        <form action="Order.php" method="GET">
            <div class="form-row mx-0">
                <div class="form-group col-md-6">
                    <label for="key">廠商名稱</label>
                    <input type="text" class="form-control" id="key" name="key" value="">
                </div>
                <div class="form-group col-md-2">
                    <label for="">&nbsp;</label>
                    <button type="submit" class="btn btn-success" style="display: block">送出</button>
                </div>
            </div>
        </form>
        <script>
            function ReloadPage(){
                window.location.reload();
            }

            function orderToCheck(id, status, reduceC = 0) {
                if (status === 1) {
                    if (confirm('確定通過？') == true) {
                        let toAddr = $('#record' + id).text();
                        sendHDC(reduceC, toAddr).then(tx => {
                            $.ajax({
                                url: 'Order_to_check.php',
                                type: 'POST',
                                data: {
                                    id: id,
                                    status: status,
                                    tx: tx
                                },
                                error: function(xhr) {
                                    alert('Error.');
                                },
                                success: function(res) {
                                    // alert('Success.')
                                    console.log(res);
                                    ReloadPage();
                                }
                            });
                        }).catch(err => {
                            console.log(err);
                        });;
                    }
                }
                if (status === 2) {
                    if (confirm('確定駁回？') == true) {
                        $.ajax({
                            url: 'Order_to_check.php',
                            type: 'POST',
                            data: {
                                id: id,
                                status: status
                            },
                            error: function(xhr) {
                                alert('Error.');
                            },
                            success: function(res) {
                                // alert('Success.')
                                console.log(res);
                                ReloadPage();
                            }
                        });
                    }
                }
            }
        </script>
    </body>
</html>

<?php
    include "connect_sql.php";
    include "SQLRelative.php";
    if (isset($_GET['key'])) { // Make sure really GET variable(s)
        $key = $_GET['key'];
        $tablename = "record";
        $fieldname = GetFieldName($servername, $username, $password, $db_name, $tablename);
        $sql = SelectTable($tablename,$key);
        // print_r($fieldname); die();
        // [0] => ID [1] => CardID [2] => ProductID [3] => Price [4] => Quantity [5] => Time [6] => Company [7] => tx [8] => Status
        // echo $sql;
        // To show searching result(s)
        $OrderInfo = array();
        $fieldname_chinese = array("ID", "買方","商品名稱", "商品價格", "購買數量", "提交日期", "廠商名稱", "狀態");
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                for ($i = 0; $i < count($fieldname_chinese); $i++) {
                    if ($i != 0) {
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
                            switch ($row[$fieldname[$i]]) {
                                case 1:
                                    echo "<td><span class='text-success'>PASS(" . $txLink . ")</span></td>";
                                    break;
                                case 2:
                                    echo "<td><span class='text-danger'>FAIL</span></td>";
                                    break;
                                default:
                                    echo "<td>";
                                    echo "<span class='badge badge-success' onclick='orderToCheck(" . $id . ", 1, " . $reduceC . ")'>PASS</span>";
                                    echo "<span class='badge badge-danger' onclick='orderToCheck(" . $id . ", 2)'>FAIL</span>";
                                    echo "</td>";
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
                            // 不要顯示 `tx(7)`
                            else if ($i == 7) {}
                            else if ($i == 1) {
                                $id = $row[$fieldname[0]];
                                $name = getNameBYCID($servername, $username, $password, $db_name, $id);
                                echo "<td title='" . $name . "'>" . $name . "</td>";
                            }
                            else if ($i == 2) {
                                $id = $row[$fieldname[0]];
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
                    echo "</tr>";
                }
                // print_r($OrderInfo);
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
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
    }

    // Close connection
    mysqli_close($conn);
?>

<?php
    function SelectTable($tablename,$key) {
        $sql = "SELECT * FROM $tablename WHERE Company LIKE \"%$key%\" ORDER BY id DESC";
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
                // echo "No result!<br/>";
                return -1;
            }
            mysqli_free_result($res);
        }
        // print($name);
        return $name;
    }

    function getNameBYCID($servername,$username,$password,$db_name,$id){
        $member_table = "member";
        $member_fieldname = GetFieldName($servername, $username, $password, $db_name, $member_table);
        $record_table = "record";
        $record_fieldname = GetFieldName($servername, $username, $password, $db_name, $record_table);
        // print_r($member_fieldname);
        //[0] => ID [1] => name [2] => CardID [3] => Ether [4] => HDC
        // print_r($record_fieldname);
        //[0] => ID [1] => CardID [2] => ProductID [3] => Price [4] => Quantity [5] => Time [6] => Company [7] => Status
        $sql = "SELECT ".$member_table.".".$member_fieldname[1]." FROM ".$member_table.",".$record_table." WHERE ".$member_table.".".$member_fieldname[2]."=".$record_table.".".$record_fieldname[1]." AND ".$record_table.".".$member_fieldname[0]."=".$id.";";
        // echo $sql; die();
        $conn = mysqli_connect($servername, $username, $password, $db_name);
        $name;
        if ($res = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    $name = $row[$member_fieldname[1]];
                }
            }
            else {
                // echo "No result!<br/>";
                return -1;
            }
            mysqli_free_result($res);
        }
        // print($name);
        return $name;
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
                // echo "No result!<br/>";
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
?>