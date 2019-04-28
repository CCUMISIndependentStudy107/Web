<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>產品審查</title>
        <script src="https://code.jquery.com/jquery-3.4.0.js" integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo=" crossorigin="anonymous"></script>
    </head>
    <body>
        <form action="Review.php" method="GET">
            <p>選擇欄位:
                <select name="Field">
                    <option value="Company">廠商名稱</option>
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
                輸入關鍵字: <input type="text" name="key" value="">
                <button>送出</button>
            </p>
        </form>
        <script>
            function reviewToCheck(id, status) {
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
                    }
                });
            }
        </script>
    </body>
</html>
<?php
    include "connect_sql.php";

    if (isset($_GET['Field']) && isset($_GET['key'])) { // Make sure really GET variable(s)
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

        // To show searching result(s)
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                for ($i = 0; $i < count($ProductInfoName); $i++)
                    echo "<th>" . $ProductInfoName[$i] . "</th>";
                $check = "審查結果";
                echo "<th>" . $check . "</th>";
                echo "</tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    for ($i = 0, $j = 0; $i < count($ProductInfoName); $i++) {
                        echo "<td>" . $row[$ProductInfoName[$i]] . "</td>";
                        $id = $row[$ProductInfoName[0]];
                        if ($i > 0)
                            $info[$id][$j++] = $row[$ProductInfoName[$i]];
                    }
                    echo "<td>";;
                    echo "<button onclick=\"reviewToCheck(" . $id . ", 1)\">通過</button>";
                    echo "<button onclick=\"reviewToCheck(" . $id . ", 2)\">駁回</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
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