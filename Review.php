<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>產品審查</title>
    </head>
    <body>
        <form method="post" action="Review.php">
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
                </select>
            </p>
            <p>輸入關鍵字:<input type="text" name="key" value=""></p>
            <input type="submit" name="button" value="送出">
        </form>
    </body>
</html>
<?php
    include "connect_sql.php";
    $ProductInfoName = array("ID","Name","Price","Quantity","Information","Weight","Tag","PictureName","ReduceC","FolderName","Company");
    $tableName = 'preprocess';
    $sql = "SELECT * FROM ".$tableName." ";
    // echo $sql;
    // $data = mysql_query($sql);
    // // echo "Count : ".mysql_num_rows($data)."<br/>";
    // for($i=1;$i<=mysql_num_rows($data);$i++) $resarr = mysql_fetch_row($data);
    // for($i=0;$i<count($resarr);$i++) echo $resarr[$i]."<br/>";
    $key = "";
    if(isset($_POST['key'])) $key = $_POST['key'];
    if(array_key_exists('button',$_POST)){
        $selected_value = $_POST['Field'];
        if($key !== ""){
            if($selected_value == "Company" || $selected_value == "Name" || $selected_value == "Information" || $selected_value == "Tag" || $selected_value == "PictureName" || $selected_value == "FolderName") 
                $sql .= "WHERE ".$selected_value." LIKE \"%".$key."%\"";
            else
                $sql .= "WHERE ".$selected_value.$key;
        }
        // echo $sql;
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table>";
                echo "<tr>";
                for($i=0;$i<count($ProductInfoName);$i++)
                    echo "<th>".$ProductInfoName[$i]."</th>";
                echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    for($i=0;$i<count($ProductInfoName);$i++)
                        echo "<td>" . $row[$ProductInfoName[$i]] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            }
            else{
                echo "No records matching your query were found.";
            }
        }
        else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    }
    // Close connection
    mysqli_close($conn);
?>