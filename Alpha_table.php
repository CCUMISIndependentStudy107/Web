<?php
    include "connect_sql.php";
    include "SQLRelative.php";
    if (isset($_POST['name'])){
        date_default_timezone_set("Asia/Taipei");
        $date = new DateTime('now');
        $date = $date->format('Y-m-d-H-i-s');
        $productname = $_POST['name'];
        $quantity = $_POST['quantity'];
        $material = $_POST['material'];
        $weight = $_POST['weight'];
        $tx = $_POST['tx'];
        $company = $_POST['company'];
        $img_name = ImageCheck($date);

        $tablename = "profile";
        $sql = "CREATE TABLE IF NOT EXISTS $tablename (ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,Company VARCHAR(100),ProductName VARCHAR(100),Quantity INT,Material VARCHAR(100),Weight FLOAT,Contract VARCHAR(100),Image VARCHAR(100),Date DATETIME)";
        // echo $sql;
        if($conn -> query($sql) == false) echo "Failed to create table ".$tablename."<br/>";
        // else echo "Table create successfully!<br/>";
        $fieldname = GetFieldName($servername, $username, $password, $db_name, $tablename);
        // print_r($fieldname);
        //[0] => ID [1] => Company [2] => ProductName [3] => Quantity [4] => Material [5] => Weight [6] => Contract [7] => Image [8] => Date
        if (!Duplicate($servername, $username, $password, $db_name, $tablename, $fieldname, $productname, $company)) {
            $sql = "INSERT INTO $tablename(";
            for ($i = 1; $i < count($fieldname); $i++) {
                if ($i != count($fieldname) - 1)
                    $sql .= $fieldname[$i] . ",";
                else
                    $sql .= $fieldname[$i] . ") VALUES(";
            }
            $sql .= "\"$company\",\"$productname\",$quantity,\"$material\",$weight,\"$tx\",\"$img_name\",\"$date\")";
            // echo $sql;
            if ($conn -> query($sql) == false) {
                echo "Failed to insert values! <br/>";
                header("refresh:1; url=./self.html", true, 301);
                exit();
            }
        }
        else {
            echo "Duplicate! can't insert values! <br/>";
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

    function Duplicate($servername,$username,$password,$db_name,$tablename,$fieldname,$productname,$companyname){
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        $sql = "SELECT * FROM ".$tablename." ";
        $arr = array();
        $product = array($productname);
        $company = array($companyname);
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
        //[0] => Companyname [1] => ProductName [2] => Quantity [3] => Material [4] => Weight [5] => tx [6] => Imgname [7] => Date
        $keys = array_keys($arr);
        // print_r($keys);
        for($i=0;$i<count($keys);$i++){
            array_push($product,$arr[$keys[$i]][1]);
            array_push($company,$arr[$keys[$i]][0]);
        }
        // print_r($product)."QQQ";
        // print_r($company)."AAA";
        $result = findDuplicate($product,$company);
        // if($result) echo "Yes";
        return $result;
    }

    function findDuplicate($productname,$companyname){
        for($i=0;$i<count($productname);$i++){
            for($j=$i+1;$j<count($productname);$j++){
                if($productname[$i] == $productname[$j] && $companyname[$i] == $companyname[$j]){
                    return true;
                }
            }
        }
        return false;
    }
?>