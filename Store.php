<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商城</title>
</head>
<body>
    <!-- <button type="button"><img src=""></button> -->
    <form method="POST" name="Test">
        <p>廠商名稱:<input type="text" name="CompanyName" required>
        <button type="submit">送出</button></p>
    </form>
    <?php
        include "connect_sql.php";
        if(isset($_POST["CompanyName"])){
            $companyName = $_POST["CompanyName"];
            $tablename = "product";
            FetchSQL($servername,$username,$password,$db_name,$tablename,$companyName);
        }
    ?>
    <?php
        function FetchSQL($servername,$username,$password,$db_name,$tablename,$companyName){
            $conn = mysqli_connect($servername, $username, $password, $db_name);
            $arr = array();
            $get_field = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`= \"$db_name\" AND `TABLE_NAME`= \"$tablename\";";
            $res = mysqli_query($conn,$get_field);
            // while($row = mysqli_fetch_array($res)){
            //     echo $row['Name']."<br>";
            // }
            // if($res = mysqli_query($conn, $sql)){
            //     while($row = mysqli_fetch_array($res)){
            //         for($i=0,$j=0;$i<$fieldnum;$i++){
            //             // echo "<td>" . $row[$fieldname[$i]] . "</td><br/>";
            //             $id = $row[$fieldname[0]];
            //             if($i>0) $arr[$id][$j++]=$row[$fieldname[$i]];
            //         }
            //     }
            // }
        }
    ?>
</body>
</html>