<?php
    include "connect_sql.php";
    include "SQLRelative.php";
    if (isset($_POST['name'])){
        date_default_timezone_set("Asia/Taipei");   //change time zone to Taipei https://www.php.net/manual/en/timezones.php
        $date = new DateTime('now');
        $date = $date->format('Y-m-d-H-i-s');   //date format
        $productname = $_POST['name'];
        $quantity = $_POST['quantity'];
        $material = $_POST['material'];
        $weight = $_POST['weight'];
        $tx = $_POST['tx'];
        $company = $_POST['company'];
        $img_name = ImageCheck($date);
        // [0] => Company [1] => ProductName [2] => Quantity [3] => Material [4] => Weight [5] => Contract [6] => Image [7] => Date
        $arr = array($company,$productname,$quantity,$material,$weight,$tx,$img_name,$date);
        // print_r($arr);

        $tablename = "profile";
        $backupTable = "profile_backup";
        $sql = "CREATE TABLE IF NOT EXISTS $tablename (ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,Company VARCHAR(100),ProductName VARCHAR(100),Quantity INT,Material VARCHAR(100),Weight FLOAT,Contract VARCHAR(100),Image VARCHAR(100),Date DATETIME)";
        // echo $sql;
        if($conn -> query($sql) == false) echo "Failed to create table ".$tablename."<br/>";
        // else echo "Table create successfully!<br/>";
        $fieldname = GetFieldName($servername, $username, $password, $db_name, $tablename);
        // print_r($fieldname);
        //[0] => ID [1] => Company [2] => ProductName [3] => Quantity [4] => Material [5] => Weight [6] => Contract [7] => Image [8] => Date
        if(!Duplicate($servername,$username,$password,$db_name,$tablename,$fieldname,$company)){
            $sql = "INSERT INTO $tablename(";
            for($i=1;$i<count($fieldname);$i++){
                if($i != count($fieldname)-1)
                    $sql .= $fieldname[$i].",";
                else
                    $sql .= $fieldname[$i].") VALUES(";
            }
            $sql .= "\"$company\",\"$productname\",$quantity,\"$material\",$weight,\"$tx\",\"$img_name\",\"$date\")";
            // echo $sql;
            if($conn -> query($sql) == false) {
                echo "Failed to insert values! <br/>";
                header("refresh:1; url=./self.html", true, 301);
                exit();
            }
        }
        else{
            // echo "Duplicate! can't insert values! <br/>";
            $backupTable = "profile_backup";
            CreateBackupTable($conn,$backupTable);
            UpdateTable($servername,$username,$password,$db_name,$tablename,$backupTable,$company,$arr);
            header("refresh:1; url=./self.html", true, 301);
            exit();
        }

        // // Close connection
        mysqli_close($conn);
        header("refresh:1; url=./self.html", true, 301);
        exit();
    }

    function ImageCheck($date){
        # 檢查檔案是否上傳成功
        if ($_FILES['product_picture']['error'] === UPLOAD_ERR_OK){
            $filetype = $_FILES['product_picture']['type'];
            if(!file_exists('uploads')) mkdir('uploads',0777,true); //0777 is already the default mode for directories and may still be modified by the current umask.
            $upload_folder = 'uploads/'.$date;
            if(!file_exists($upload_folder)) mkdir($upload_folder,0777,true); //if not exists , create one
            if(IsImage($filetype)){
                # 檢查檔案是否已經存在
                if (file_exists($upload_folder . $_FILES['product_picture']['name'])) echo '檔案已存在。<br/>';
                else{
                    $file = $_FILES['product_picture']['tmp_name'];
                    $dest = $upload_folder . "/". $_FILES['product_picture']['name'];
                    move_uploaded_file($file, $dest);   //將檔案移至指定位置
                }
            }
        }
        else{
            echo '錯誤代碼：' . $_FILES['product_picture']['error'] . '<br/>';
            return false;
        }
        return $_FILES['product_picture']['name'];
    }

    function IsImage($filetype){
        $acceptable_file_ext = "image";
        if(strpos($filetype,$acceptable_file_ext) !== false) return true;
        return false;
    }

    function Duplicate($servername,$username,$password,$db_name,$tablename,$fieldname,$companyname){
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        // print_r($fieldname);
        // [0] => ID [1] => Company [2] => ProductName [3] => Quantity [4] => Material [5] => Weight [6] => Contract [7] => Image [8] => Date
        $sql = "SELECT * FROM ".$tablename." WHERE $fieldname[1] = \"$companyname\"";
        // echo $sql;
        $arr = array();
        if($res = mysqli_query($conn, $sql)){
            while($row = mysqli_fetch_array($res)){
                for($i=0,$j=0;$i<count($fieldname);$i++){
                    // echo "<td>" . $row[$ProductInfoName[$i]] . "</td>";
                    $id = $row[$fieldname[0]];
                    if($i>0) $arr[$id][$j++]=$row[$fieldname[$i]];
                }
            }
        }
        // print_r($arr);
        $keys = array_keys($arr);
        // print_r($keys);
        if(count($keys)>0) return true;
        return false;
    }

    function UpdateTable($servername,$username,$password,$db_name,$tablename,$backupTable,$company,$info){
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        $fieldname = GetFieldName($servername, $username, $password, $db_name, $tablename);
        // print_r($fieldname);
        //[0] => ID [1] => Company [2] => ProductName [3] => Quantity [4] => Material [5] => Weight [6] => Contract [7] => Image [8] => Date
        $sql = "SELECT * FROM $tablename WHERE $fieldname[1] = \"$company\"";
        // echo $sql;
        $arr = array();
        if($res = mysqli_query($conn, $sql)){
            while($row = mysqli_fetch_array($res)){
                for($i=0,$j=0;$i<count($fieldname);$i++){
                    // echo "<td>" . $row[$ProductInfoName[$i]] . "</td>";
                    $id = $row[$fieldname[0]];
                    if($i>0) $arr[$id][$j++]=$row[$fieldname[$i]];
                }
            }
        }
        // print_r($arr);
        //[key] => {[0],[1],....}
        // [0] => leaflu [1] => leaflu [2] => 1 [3] => bamboo [4] => 123 [5] => 0x282BA262A8d9452F55c8c7373486920Aa9ff90f2
        // [6] => 1010152_913705305313905_769581291051537142_n.jpg [7] => 2019-05-13 20:35:56
        $keys = array_keys($arr);
        // print_r($keys);
        if(count($keys)>0){
            //INSERT INTO BACKUP TABLE
            $sql = "INSERT INTO $backupTable (";
            for($i=1;$i<count($fieldname);$i++){
                if($i != count($fieldname)-1)
                    $sql .= $fieldname[$i].",";
                else
                    $sql .= $fieldname[$i].") VALUES(";
            }
            for($i=0;$i<count($fieldname)-1;$i++){
                switch($i){
                    case 0: case 1: case 3: case 5: case 6:
                        $sql .= "\"".$arr[$keys[0]][$i]."\",";
                        break;
                    case count($fieldname)-2:
                        $sql .= "\"".$arr[$keys[0]][$i]."\")";
                        break;
                    default:
                        $sql .= $arr[$keys[0]][$i].",";
                }
            }
            // echo $sql;
            if($conn -> query($sql) == false) die("Failed to insert to backup table ".$backupTable."<br/>");
            // DELETE OLD VALUES
            $sql = "DELETE FROM $tablename WHERE $fieldname[1] = \"$company\";";
            if($conn -> query($sql) == false) die("Failed to delete row : company = ".$company."<br/>");
            $sql = "INSERT INTO $tablename (";
            for($i=1;$i<count($fieldname);$i++){
                if($i != count($fieldname)-1)
                    $sql .= $fieldname[$i].",";
                else
                    $sql .= $fieldname[$i].") VALUES(";
            }
            for($i=0;$i<count($fieldname)-1;$i++){
                switch($i){
                    case 0: case 1: case 3: case 5: case 6:
                        $sql .= "\"".$info[$i]."\",";
                        break;
                    case count($fieldname)-2:
                        $sql .= "\"".$info[$i]."\")";
                        break;
                    default:
                        $sql .= $info[$i].",";
                }
            }
            // echo $sql;
            if($conn -> query($sql) == false) die("Failed to update values <br/>");
        }
    }

    function CreateBackupTable($conn,$tablename){
        $sql = "CREATE TABLE IF NOT EXISTS $tablename (ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,Company VARCHAR(100),ProductName VARCHAR(100),Quantity INT,Material VARCHAR(100),Weight FLOAT,Contract VARCHAR(100),Image VARCHAR(100),Date DATETIME)";
        if($conn -> query($sql) == false) die("Failed to create table ".$tablename."<br/>");
    }
?>