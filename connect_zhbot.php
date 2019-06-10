<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>輸入資料庫</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    </head>
    <body>
        <img src="pic/zhbot.png" onclick="window.location.reload();">
        <form>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="button" class="btn btn-success" onclick="javascript:location.href='new.html'">繼續上架</button>
                </div>
            </div>
        </form>
        <br/>
    </body>
</html>
<?php
    include "connect_sql.php";
    include "SQLRelative.php";
    include "Duplicate.php";

    $ProductInfoName = array("ID","Name","Price","Quantity","Information","Weight","Tag","PictureName","ReduceC","FolderName","Company", "tx");
    $check = "checks";
    $tablename = CreateTable($servername,$username,$password,$db_name,$ProductInfoName,$check);
    $filename = "PlainInfo.html";
    $ProductInfo = ReadPlainText($filename);
    $ProductInfo[5] = TagProcess($ProductInfo[5]);
    // print_r($ProductInfo);

    // INSERT INTO TABLE preprocess
    $conn = mysqli_connect($servername,$username,$password,$db_name);

    if(Duplicate($servername,$username,$password,$db_name,$tablename,$ProductInfoName,$ProductInfo)){
        echo "Failed to insert because of the duplicate<br/>";
    }
    else{
        $sql = "INSERT INTO ".$tablename."(";
        for($i=1;$i<count($ProductInfoName);$i++)
            if ($i != count($ProductInfoName)-1)
                $sql .= $ProductInfoName[$i].",";

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
        // echo $sql; die();
        if($conn -> query($sql) == false){
            echo "Failed to Insert values <br/>";
        }
        else {
            header('Location: ./new.html');
        }
        mysqli_close($conn);
    }
    // Beta table
    $betaTable = "beta";
    $pid = GetPID($servername,$username,$password,$db_name,$ProductInfo[0],$ProductInfo[9]);
    Beta($servername,$username,$password,$db_name,$ProductInfo[0],$ProductInfo[9],$pid);
    $arr = GetProductInfo($servername, $username, $password, $db_name, $betaTable, $pid);
    print_r($arr);
?>

<?php
    function CreateTable($servername,$username,$password,$db_name,$array,$check){
        /* CREATE TABLE */
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        $tableName = 'preprocess';
        $sql = "CREATE TABLE IF NOT EXISTS ".$tableName." (".$array[0]." INT NOT NULL AUTO_INCREMENT PRIMARY KEY,".$array[1]." VARCHAR(200),".$array[2]." INT,".$array[3]." INT,".$array[4]." VARCHAR(200),".$array[5]." FLOAT,".$array[6]." VARCHAR(100),".$array[7]." VARCHAR(100),".$array[8]." FLOAT,".$array[9]." VARCHAR(100),".$array[10]." VARCHAR(100),".$array[11]." VARCHAR(255) NULL,".$check." BOOLEAN);";
        // echo $sql;
        if($conn -> query($sql) == false) echo "Failed to create table ".$tableName."<br/>";
        // else echo "Table create successfully!<br/>";
        return $tableName;
    }

    function ReadPlainText($filename){
        $upload_path = "uploads/";
        $file_path = $upload_path.$filename;
        $file = fopen($file_path,"r");
        $arr = array();
        while(!feof($file)){
            $tmp = fgets($file);
            array_push($arr,$tmp);
        }
        // print_r($arr);
        return $arr;
    }

    function TagProcess($tag){
        return str_replace(','," ",$tag);
    }

    function Beta($servername,$username,$password,$db_name,$ProductName,$Company,$pid){
        $beta_file = "beta.txt";
        $info = ReadPlainText($beta_file);
        $InfoName = array('ID','PID','ProductName','Company','Material1','Electric1','Process1_1','Process1_2',
        'Mileage1','Gasoline1','Material2','Electric2','Process2_1','Process2_2','Mileage2','Gasoline2','Mweight1',
        'Mweight2','MElec','MWeight','Expiration','Bamboo','value');
        // print_r($info);
        $arr = array($pid,$ProductName,$Company);
        for($i=0;$i<count($info);$i++){
            array_push($arr,$info[$i]);
        }
        // print_r($arr);
        $tableName = CreateBetaTable($servername,$username,$password,$db_name,$InfoName);
        $sql = "INSERT INTO $tableName (";
        for($i=1;$i<count($InfoName);$i++){
            if($i != count($InfoName)-1) $sql .= $InfoName[$i].",";
            else $sql .= $InfoName[$i].") VALUES(";
        }
        for($i=0;$i<count($arr);$i++){
            switch($i){
                //Product Name, Company , Material Names
                case 1: case 2: case 3: case 9:
                    $sql .= "\"$arr[$i]\",";
                    break;
                case count($arr)-1:
                    $sql .= $arr[$i].");";
                    break;
                default:
                    $sql .= "$arr[$i],";
                    break;
            }
        }
        echo $sql;
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        if($conn -> query($sql) == false){
            echo "Failed to Insert values in beta table<br/>";
        }
        else{
            // echo "成功輸入至資料庫！<br/>";
        }
    }

    function CreateBetaTable($servername,$username,$password,$db_name,$InfoName){
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        $tableName = 'beta';

        $sql = "CREATE TABLE IF NOT EXISTS ".$tableName." (".$InfoName[0]." INT NOT NULL AUTO_INCREMENT PRIMARY KEY,".$InfoName[1]." INT,".$InfoName[2]." VARCHAR(200),".$InfoName[3]." VARCHAR(200),".$InfoName[4]." VARCHAR(200),".$InfoName[5]." FLOAT,".$InfoName[6]." FLOAT,".$InfoName[7]." FLOAT,".$InfoName[8]." FLOAT,".$InfoName[9]." FLOAT,".$InfoName[10]." VARCHAR(200),".$InfoName[11]." FLOAT,".$InfoName[12]." FLOAT,".$InfoName[13]." FLOAT,".$InfoName[14]." FLOAT,".$InfoName[15]." FLOAT,".$InfoName[16]." FLOAT,".$InfoName[17]." FLOAT,".$InfoName[18]." FLOAT,".$InfoName[19]." FLOAT,".$InfoName[20]." INT,".$InfoName[21]." FLOAT,".$InfoName[22]." FLOAT);";
        // echo $sql;
        if($conn -> query($sql) == false) echo "Failed to create table ".$tableName."<br/>";
        // else echo "Table create successfully!<br/>";
        return $tableName;
    }

    function GetPID($servername,$username,$password,$db_name,$ProductName,$Company){
        $conn = mysqli_connect($servername, $username, $password, $db_name);
        $tablename = "preprocess";
        $fieldName = GetFieldName($servername, $username, $password, $db_name, $tablename);
        $fieldnum = count($fieldName);
        $sql = "SELECT * FROM $tablename WHERE ".$fieldName[1]."=\"$ProductName\" AND $fieldName[10] = \"$Company\"";
        echo $sql;
        if ($res = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    $id = $row[$fieldName[0]];
                    return $id;
                }
            }
            else {
                echo "No result!<br/>";
                return -1;
            }
            mysqli_free_result($res);
        }
    }
?>