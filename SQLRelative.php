<?php
    function GetFieldName($servername,$username,$password,$db_name,$tablename){
        $db = new mysqli($servername, $username, $password, $db_name);
        $get_field = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`= \"$db_name\" AND `TABLE_NAME`= \"$tablename\";";
        $query = $db->query($get_field);
        while($row = $query->fetch_assoc()){
            $result[] = $row;
        }
        // Array of all column names
        $fields = array_column($result, 'COLUMN_NAME');
        return $fields;
    }

    function GetProductInfo($servername,$username,$password,$db_name,$tablename,$pid){
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        if(!$conn) die("Can't access to sql!<br/>");
        $fieldName = GetFieldName($servername,$username,$password,$db_name,$tablename);
        $fieldnum = count($fieldName);
        $sql = "SELECT * FROM $tablename WHERE ".$fieldName[0]."=$pid";
        $arr = array();
        if ($res = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    for ($i = 0, $j = 0; $i < $fieldnum; $i++) {
                        $id = $row[$fieldName[0]];
                        $arr[$id][$j++] = $row[$fieldName[$i]];
                    }
                }
            }
            else {
                echo "No result!<br/>";
                return ;
            }
            mysqli_free_result($res);
        }
        $keys = array_keys($arr);
        if(count($keys)>1){
            echo "Why?";
            return;
        }
        // for($i=0;$i<count($keys);$i++){
        //     print_r($arr[$keys[$i]]);
        // }
        mysqli_close($conn);
        return $arr[$keys[0]];
    }
?>