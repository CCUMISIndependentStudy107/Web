<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>產品審查</title>
    </head>
    <body>
        <p>輸入關鍵字:<input type="text" name="search" value="">
        <input type="submit" name="button" value="送出"></p>
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
                } else{
                    echo "No records matching your query were found.";
                }
            }
            else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
            // Close connection
            mysqli_close($conn);
        ?>
    </body>
</html>