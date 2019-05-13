<?php
    include "connect_sql.php";
    include "SQLRelative.php";

    // Create `product` table to database
    function CreateProductTable($servername, $username, $password, $db_name, $array) {
        $conn = mysqli_connect($servername, $username, $password, $db_name);
        $tableName = "product";

        // Create `product` table if not exists
        $sql = "CREATE TABLE IF NOT EXISTS " . $tableName . " (" . $array[0] . " INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " . $array[1] . " VARCHAR(200), " . $array[2] . " INT, " . $array[3] . " INT, " . $array[4] . " VARCHAR(200), " . $array[5] . " FLOAT, " . $array[6] . " VARCHAR(100), " . $array[7] . " VARCHAR(100), " . $array[8] . " FLOAT, " . $array[9] . " VARCHAR(100), " . $array[10] . " VARCHAR(100), " . $array[11] . " VARCHAR(255));";

        // Catch error: failed to create table
        if($conn -> query($sql) == false)
            return "ERROR";

        return $tableName;
    }

    if (isset($_POST["id"]) && isset($_POST["status"])) { // Make sure really POST variable(s)
        $id = $_POST["id"];
        $status = $_POST["status"];
        $tx = ($status == 1) ? $_POST["tx"] : "fail";

        // "$status == 1" means it is set to be an available product
        // In addition to update status in database, it IS ABOUT TO be inserted a copy into the new table, `product`
        if ($status == 1) {
            $ProductInfoName = array("ID", "Name", "Price", "Quantity", "Information", "Weight", "Tag", "PictureName", "ReduceC", "FolderName", "Company", "tx", "checks");
            $newtable = CreateProductTable($servername, $username, $password, $db_name, $ProductInfoName);

            // If got error(s) while creating `product` table, shut down
            if ($newtable == "ERROR") {
                echo "Failed to create new table. \n";
                exit();
            }
        }

        // Update status
        $conn = mysqli_connect($servername, $username, $password, $db_name);
        $tableName = "preprocess";
        $sql = "UPDATE `" . $tableName . "` SET `checks`=" . $status . ", `tx`='" . $tx . "' WHERE `ID`=" . $id . ";";

        // Catch error
        if ($conn->query($sql) === false)
            echo "Failed to update STATUS.";
        else
            echo "Record updated successfully.";

        // Check `SUCCESS` and insert a copy into new table
        if ($status == 1) {
            $oldtable = "preprocess";
            if(!DuplicateID($servername,$username,$password,$db_name,$newtable,$id)){
                // Complex sql syntax
                $sql = "INSERT INTO " . $newtable . " (";
                for ($i = 1; $i < count($ProductInfoName) - 1; $i++)
                    $sql .= $ProductInfoName[$i] . ",";
                $sql .= $ProductInfoName[count($ProductInfoName) - 1] . ") SELECT ";
                for ($i = 1; $i < count($ProductInfoName) - 1; $i++)
                    $sql .= $ProductInfoName[$i] . ",";
                $sql .= $ProductInfoName[count($ProductInfoName) - 1];
                $sql .= " FROM " . $oldtable . " WHERE ID=" . $id . ";";

                // Catch error
                if($conn -> query($sql) == false)
                    echo "Failed to insert to table " . $newtable . " \n";
                else
                    echo "Record insert successfully. \n";
            }
            else{
                echo "You have already insert into it!<br/>";
            }
        }

        // Close connection
        mysqli_close($conn);
    }
    else {
        // Catch error
        header("Location: Review.php", true, 301);
        exit();
    }
?>

<?php
    function DuplicateID($servername,$username,$password,$db_name,$tablename,$id){
        // tablename = product
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        if(!$conn) die("Failed to connect to sql!<br/>");
        $fieldName = GetFieldName($servername,$username,$password,$db_name,$tablename);
        $sql = "SELECT * FROM $tablename WHERE $fieldName[0] = $id";
        if($result=mysqli_query($conn,$sql)){
            if(mysqli_num_rows($result)>0) return true;
        }
        else{
            echo "Can't select from table $tablename <br/>";
        }
        return false;
    }
?>