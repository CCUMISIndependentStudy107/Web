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
?>