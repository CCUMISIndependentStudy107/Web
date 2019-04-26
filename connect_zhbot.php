<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>輸入資料庫</title>
    </head>
    <body>
    </body>
</html>
<?php
    include "connect_sql.php";
    $ProductInfoName = array("ID","Name","Price","Quantity","Information","Weight","Tag","PictureName","ReduceC","FolderName","Company");
    $check = "checks";
    $tablename = CreateTable($servername,$username,$password,$db_name,$ProductInfoName,$check);
    $ProductInfo = ReadPlainText();
    $ProductInfo[5] = TagProcess($ProductInfo[5]);
    // print_r($ProductInfo);
    // INSERT INTO DATABASE
    /* Not sure these works */
    // $db=mysql_connect($servername,$username,$password);
    // mysql_query("set character set utf8",$db);
    // mysql_query("SET CHARACTER_SET_database= utf8",$db);
    // mysql_query("SET CHARACTER_SET_CLIENT= utf8",$db);
    // mysql_query("SET CHARACTER_SET_RESULTS= utf8",$db);
    // mysql_query("SET NAMES 'UTF8'");
    $conn = mysqli_connect($servername,$username,$password,$db_name);
    // $sql = "INSERT INTO ".$tablename." (".$ProductInfoName[1].",".$ProductInfoName[2].",".$ProductInfoName[3].",".$ProductInfoName[4].",".$ProductInfoName[5].",".$ProductInfoName[6].",".$ProductInfoName[7].",".$ProductInfoName[8].",".$ProductInfoName[9].",".$ProductInfoName[10].",".$check.")";
    // $sql .= " VALUES(\"".$ProductInfo[0]."\",".$ProductInfo[1].",".$ProductInfo[2].",\"".$ProductInfo[3]."\",".$ProductInfo[4].",\"".$ProductInfo[5]."\",\"".$ProductInfo[6]."\",".$ProductInfo[7].",\"".$ProductInfo[8]."\",\"".$ProductInfo[9]."\",0);";
    if(Duplicate($servername,$username,$password,$db_name,$tablename,$ProductInfoName,$ProductInfo)){
        echo "Failed to insert because of the duplicate<br/>";
    }
    else{
        $sql = "INSERT INTO ".$tablename."(";
        for($i=1;$i<count($ProductInfoName);$i++) $sql .= $ProductInfoName[$i].",";
        $sql .= $check.") VALUES(";
        for($i=0;$i<count($ProductInfo);$i++){
            switch($i){
                case 0: case 3: case 5: case 6: case 8: case 9:
                    $sql .= "\"$ProductInfo[$i]\",";
                    break;
                default:
                    $sql .= $ProductInfo[$i].",";
                    break;
            }
        }
        $sql .= "0);";
        // echo $sql;
        if($conn -> query($sql) == false) echo "Failed to Insert values <br/>";
        else echo "成功輸入至資料庫！<br/>";
        mysqli_close($conn);
    }
?>

<?php
    function CreateTable($servername,$username,$password,$db_name,$array,$check){
        /* CREATE TABLE */
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        $tableName = 'preprocess';
        $sql = "CREATE TABLE IF NOT EXISTS ".$tableName." (".$array[0]." INT NOT NULL AUTO_INCREMENT PRIMARY KEY,".$array[1]." VARCHAR(200),".$array[2]." INT,".$array[3]." INT,".$array[4]." VARCHAR(200),".$array[5]." FLOAT,".$array[6]." VARCHAR(100),".$array[7]." VARCHAR(100),".$array[8]." FLOAT,".$array[9]." VARCHAR(100),".$array[10]." VARCHAR(100),".$check." BOOLEAN);";
        // echo $sql;
        if($conn -> query($sql) == false) echo "Failed to create table ".$tableName."<br/>";
        // else echo "Table create successfully!<br/>";
        return $tableName;
    }

    function ReadPlainText(){
        $file = fopen("uploads/PlainInfo.html","r");
        $ProductInfo = array();
        while(!feof($file)){
            $tmp = fgets($file);
            array_push($ProductInfo,$tmp);
        }
        // print_r($ProductInfo);
        return $ProductInfo;
    }

    function TagProcess($tag){
        return str_replace(','," ",$tag);
    }

    function Duplicate($servername,$username,$password,$db_name,$tablename,$ProductInfoName,$ProductInfo){
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        $sql = "SELECT * FROM ".$tablename." ";
        $arr = array();
        $productname = array($ProductInfo[0]);
        $companyname = array($ProductInfo[9]);
        if($res = mysqli_query($conn, $sql)){
            while($row = mysqli_fetch_array($res)){
                for($i=0,$j=0;$i<count($ProductInfoName);$i++){
                    // echo "<td>" . $row[$ProductInfoName[$i]] . "</td>";
                    $id = $row[$ProductInfoName[0]];
                    if($i>0) $arr[$id][$j++]=$row[$ProductInfoName[$i]];
                }
            }
        }
        $keys = array_keys($arr);
        // print_r($keys);
        for($i=0;$i<count($keys);$i++){
            array_push($productname,$arr[$keys[$i]][0]);
            array_push($companyname,$arr[$keys[$i]][9]);
        }
        // print_r($productname)."QQQ";
        // print_r($companyname)."AAA";
        $result = findDuplicate($productname,$companyname);
        return $result;
    }

    function findDuplicate($productname,$companyname){
        for($i=0;$i<count($productname);$i++){
            for($j=$i+1;$j<count($productname);$j++){
                if($productname[$i] == $productname[$j] && $companyname[$i] == $companyname[$j]) return true;
            }
        }
        return false;
    }
?>