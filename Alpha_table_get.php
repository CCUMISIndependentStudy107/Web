<?php
    include "connect_sql.php";
    include "SQLRelative.php";
    $tablename = "profile";
    $companyname = $_POST['username'];
    $AllInfo = getAll($servername,$username,$password,$db_name,$tablename,$companyname);
    // print_r($AllInfo);
    // [0] => Company [1] => ProductName [2] => Quantity [3] => Material [4] => Weight [5] => Contract [6] => Image [7] => Date
    $dataToJson = [
        "productName" => $AllInfo[1],
        "quantity" => $AllInfo[2],
        "material" => $AllInfo[3],
        "weight" => $AllInfo[4],
        "tx" => $AllInfo[5]
    ];
    $result = json_encode($dataToJson, JSON_UNESCAPED_UNICODE);
    echo $result;
?>

<?php
    function getAll($servername,$username,$password,$db_name,$tablename,$companyname){
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        $fieldname = GetFieldName($servername,$username,$password,$db_name,$tablename);
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
        return $arr[$keys[0]];
    }
?>