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
        include "GetFieldName.php";
        if(isset($_POST["CompanyName"])){
            $companyName = $_POST["CompanyName"];
            // $tablename = "product";
            $tablename = "preprocess";
            $fieldName = GetFieldName($servername,$username,$password,$db_name,$tablename);   //array
            FetchSQL($servername,$username,$password,$db_name,$tablename,$fieldName,$companyName);
        }
    ?>
    <?php
        function FetchSQL($servername,$username,$password,$db_name,$tablename,$fieldName,$companyName){
            // print_r($fieldName);
            //[0] => ID [1] => Name [2] => Price [3] => Quantity [4] => Information [5] => Weight [6] => Tag
            //[7] => PictureName [8] => ReduceC [9] => FolderName [10] => Company [11] => tx [12] => checks
            $conn = mysqli_connect($servername,$username,$password,$db_name);
            if (!$conn) die("Connection failed: " . mysqli_connect_error()."<br/>");    //not connected then die
            $sql = "SELECT * FROM $tablename WHERE $fieldName[10] = \"$companyName\" AND $fieldName[12] = 1";
            // echo $sql;
            if($conn -> query($sql) == false){
                echo "There is no result where company = $companyName<br/>";
            }
            else{
                $fieldnum = count($fieldName);
                if($res = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($res)>0){
                        while($row = mysqli_fetch_array($res)){
                            for($i=0,$j=0;$i<$fieldnum;$i++){
                            // echo "<td>" . $row[$fieldname[$i]] . "</td><br/>";
                                $id = $row[$fieldName[0]];
                                $arr[$id][$j++]=$row[$fieldName[$i]];
                            }
                        }
                    }
                    else{
                        echo "No result!<br/>";
                        return ;
                    }
                    mysqli_free_result($res);
                }
                $keys = array_keys($arr);
                // print_r($keys);
                for($i=0;$i<count($keys);$i++){
                    $path = "uploads/";
                    echo "<div><button type=\"button\"><img src=\"".$path.$arr[$keys[$i]][9]."/".$arr[$keys[$i]][7]."\">".$arr[$keys[$i]][1]."</button></div>";  //print 1=name 9=folder 7=pic
                }
            }
        }
    ?>
</body>
</html>