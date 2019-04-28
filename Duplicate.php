<?php
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