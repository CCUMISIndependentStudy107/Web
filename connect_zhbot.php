<?php
    include "connect_sql.php";
    $ProductInfoName = array("ID","Name","Price","Quantity","Information","Weight","Tag","PictureName","ReduceC","FolderName");
    $tablename = CreateTable($servername,$username,$password,$db_name,$ProductInfoName);
    $ProductInfo = ReadPlainText();
    $ProductInfo[5] = TagProcess($ProductInfo[5]);
    // print_r($ProductInfo);
    // INSERT INTO DATABASE
    $conn = mysqli_connect($servername,$username,$password,$db_name);
    $sql = "INSERT INTO ".$tablename." (".$ProductInfoName[1].",".$ProductInfoName[2].",".$ProductInfoName[3].",".$ProductInfoName[4].",".$ProductInfoName[5].",".$ProductInfoName[6].",".$ProductInfoName[7].",".$ProductInfoName[8].",".$ProductInfoName[9].")";
    $sql .= " VALUES(\"".$ProductInfo[0]."\",".$ProductInfo[1].",".$ProductInfo[2].",\"".$ProductInfo[3]."\",".$ProductInfo[4].",\"".$ProductInfo[5]."\",\"".$ProductInfo[6]."\",".$ProductInfo[7].",\"".$ProductInfo[8]."\");";
    // echo $sql;
    if($conn -> query($sql) == false) echo "Failed to Insert values <br/>";
?>

<?php
    function CreateTable($servername,$username,$password,$db_name,$array){
        /* CREATE TABLE */
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        $tableName = 'product';
        $sql = "CREATE TABLE IF NOT EXISTS ".$tableName." (".$array[0]." INT NOT NULL AUTO_INCREMENT PRIMARY KEY,".$array[1]." VARCHAR(200),".$array[2]." INT,".$array[3]." INT,".$array[4]." FLOAT,".$array[5]." VARCHAR(200),".$array[6]." VARCHAR(100),".$array[7]." VARCHAR(100),".$array[8]." FLOAT,".$array[9]." VARCHAR(100));";
        // echo $sql;
        if($conn -> query($sql) == false) echo "Failed to create table ".$tableName."<br/>";
        // else echo "Table create successfully!<br/>";
        return $tableName;
    }

    function ReadPlainText(){
        $file = fopen("uploads/PlainInfo.html","r");
        $ProductInfo = array();
        $index = 0;
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
?>