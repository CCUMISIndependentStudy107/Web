<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>產品審查</title>
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
        <form id="review-form" action="Review.php" method="GET">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="field">選擇欄位</label>
                    <select class="form-control" name="Field" id="field">
                        <option value="Company" selected>廠商名稱</option>
                        <option value="Name">商品名稱</option>
                        <option value="Price">產品價格</option>
                        <option value="Quantity">產品數量</option>
                        <option value="Information">產品資訊</option>
                        <option value="Weight">產品重量(g)</option>
                        <option value="Tag">標籤</option>
                        <option value="PictureName">產品照面</option>
                        <option value="FolderName">創建時間</option>
                        <option value="ReduceC">節碳量</option>
                        <option value="Checks">審查狀態</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="key">輸入關鍵字</label>
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

            function reviewToCheck(id, status, reduceC = 0) {
                if (status === 1) {
                    if (confirm('確定通過？') == true) {
                        sendHDC(reduceC).then(tx => {
                            $.ajax({
                                url: 'Review_to_check.php',
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
                            url: 'Review_to_check.php',
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
    //$id = record.id
    $eth = getEthernetBYPID($servername,$username,$password,$db_name,$id);
    if (isset($_GET['Field']) && isset($_GET['key'])) { // Make sure really GET variable(s)
        $ProductInfoName = array("ID", "Name", "Price", "Quantity", "Information", "Weight", "Tag", "PictureName", "ReduceC", "FolderName", "Company", "tx", "checks");
        $ProductInfoName_chinese = array("ID", "商品名稱","商品價格", "上架數量", "商品簡介", "商品重量", "商品標籤", "圖片", "減碳量", "提交日期", "廠商名稱", "狀態");
        $sql = SelectTable($ProductInfoName);
        // To show searching result(s)
        $ProductInfo = array();
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                for ($i = 0; $i < count($ProductInfoName_chinese); $i++) {
                    if ($i == 0 || $i == 5 || $i == 6 || $i == 7) {}
                    else {
                        echo "<th scope='col'>" . $ProductInfoName_chinese[$i] . "</th>";
                    }
                }
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    for ($i = 0, $j = 0; $i < count($ProductInfoName); $i++) {
                        if ($i == count($ProductInfoName) - 2) {
                            $txLink = "<a href='https://ropsten.etherscan.io/tx/" . $row[$ProductInfoName[$i]] . "' target='_blank'>Tx</a>";
                            continue;
                        }
                        if ($i == count($ProductInfoName) - 5)
                            $reduceC = $row[$ProductInfoName[$i]];
                        if ($i == count($ProductInfoName) - 1) {
                            // 抓 status
                            // >> status == 1: 通過(綠)，顯示 `PASS` 和 Tx address
                            // >> status == 2: 駁回(紅)，顯示 `FAIL`
                            // >> status == 0: 處理中，顯示 `PASS` 和 `FAIL`
                            switch ($row[$ProductInfoName[$i]]) {
                                case 1:
                                    echo "<td><span class='text-success'>PASS(" . $txLink . ")</span></td>";
                                    break;
                                case 2:
                                    echo "<td><span class='text-danger'>FAIL</span></td>";
                                    break;
                                default:
                                    echo "<td>";
                                    echo "<span class='badge badge-success' onclick='reviewToCheck(" . $id . ", 1, " . $reduceC . ")'>PASS</span>";
                                    echo "<span class='badge badge-danger' onclick='reviewToCheck(" . $id . ", 2)'>FAIL</span>";
                                    echo "</td>";
                                    break;
                            }
                        }
                        else {
                            // 不要顯示 `id(-13), 重量(-8), 標籤(-7), 圖片(-6)`
                            if ($i == count($ProductInfoName) - 13 || $i == count($ProductInfoName) - 8 || $i == count($ProductInfoName) - 7 || $i == count($ProductInfoName) - 6) {}
                            else {
                                echo "<td title='" . $row[$ProductInfoName[$i]] . "'>" . $row[$ProductInfoName[$i]] . "</td>";
                            }
                        }
                        $id = $row[$ProductInfoName[0]];
                        if ($i > 0){
                            // echo $i."--".$row[$ProductInfoName[$i]];
                            //product name = 1 company name=10
                            $info[$id][$j++] = $row[$ProductInfoName[$i]];
                        }
                        // echo "<br/>";
                    }
                    echo "</tr>";
                }
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
    function SelectTable($ProductInfoName) {
        $ProductInfoName = array("ID", "Name", "Price", "Quantity", "Information", "Weight", "Tag", "PictureName", "ReduceC", "FolderName", "Company", "checks");
        $selected_value = $_GET['Field'];
        $key = $_GET['key'];

        $tableName = 'preprocess';
        // Complex sql syntax
        $sql = "SELECT * FROM " . $tableName . " ";
        if ($selected_value == "Company" ||
            $selected_value == "Name" ||
            $selected_value == "Information" ||
            $selected_value == "Tag" ||
            $selected_value == "PictureName" ||
            $selected_value == "FolderName")
            $sql .= "WHERE " . $selected_value . " LIKE \"%" . $key . "%\"";
        else{
            if(is_numeric($key[0]))
                $sql .= "WHERE ".$selected_value."=".$key;
            else
                $sql .= "WHERE " . $selected_value.$key;
        }
        return $sql . " ORDER BY id DESC";
    }

    function getEthernetBYPID($servername,$username,$password,$db_name,$id){
        $member_table = "member";
        $member_fieldname = GetFieldName($servername, $username, $password, $db_name, $member_table);
        $record_table = "record";
        $record_fieldname = GetFieldName($servername, $username, $password, $db_name,$record_table);
        // print_r($member_fieldname);
        //[0] => ID [1] => name [2] => CardID [3] => Ether [4] => HDC
        // print_r($record_fieldname);
        //[0] => ID [1] => CardID [2] => ProductID [3] => Price [4] => Quantity [5] => Time [6] => Company [7] => Status
        $sql = "SELECT ".$member_table.".".$member_fieldname[3]." FROM ".$member_table.",".$record_table." WHERE ".$member_table.".".$member_fieldname[1]."=".$record_table.".".$record_fieldname[6]." AND ".$record_table.".".$member_fieldname[0]."=".$id.";";
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
        print($eth);
        return $eth;
    }
?>