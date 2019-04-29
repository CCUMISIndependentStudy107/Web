<?php
    include "connect_sql.php";
    include "Duplicate.php";
    $cardID = $_POST['CardID'];
    $ether = $_POST['Ether'];
    $fieldname = array("ID","CardID","Ether");
    $tableName = CreateMemberTable($servername,$username,$password,$db_name,$fieldname);
    if(!DuplicateMember($servername,$username,$password,$db_name,$tableName,$fieldname,$cardID,$ether)){
        InsertMember($servername,$username,$password,$db_name,$tableName,$fieldname,$cardID,$ether);
    }
    else
        echo "註冊失敗 : 卡號或以太坊位置重複註冊!";
?>

<?php
    function CreateMemberTable($servername,$username,$password,$db_name,$fieldname){
        $tableName = "member";
        $cardLength = 15;
        $etherLength = 50;
        $sql = "CREATE TABLE IF NOT EXISTS $tableName ($fieldname[0] INT NOT NULL AUTO_INCREMENT PRIMARY KEY,$fieldname[1] VARCHAR($cardLength),$fieldname[2] VARCHAR($etherLength));";
        // echo $sql;
        $conn = mysqli_connect($servername,$username,$password,$db_name); 
        if($conn -> query($sql) == false) echo "Failed to create table ".$tableName."<br/>";
        // else echo "Table create successfully!<br/>";
        return $tableName;
    }

    function DuplicateMember($servername,$username,$password,$db_name,$tablename,$fieldname,$cardid,$ether){
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        $sql = "SELECT * FROM ".$tablename." ";
        $arr = array();
        $cardid = array($cardid);
        $ether = array($ether);
        $fieldnum = count($fieldname);
        if($res = mysqli_query($conn, $sql)){
            while($row = mysqli_fetch_array($res)){
                for($i=0,$j=0;$i<$fieldnum;$i++){
                    // echo "<td>" . $row[$ProductInfoName[$i]] . "</td>";
                    $id = $row[$fieldname[0]];
                    if($i>0) $arr[$id][$j++]=$row[$fieldname[$i]];
                }
            }
        }
        $keys = array_keys($arr);
        // print_r($keys);
        for($i=0;$i<count($keys);$i++){
            array_push($cardid,$arr[$keys[$i]][0]);
            array_push($ether,$arr[$keys[$i]][1]);
        }
        $result = findDuplicate($cardid,$ether);
        return $result;
    }

    function InsertMember($servername,$username,$password,$db_name,$tablename,$fieldname,$cardid,$ether){
        $sql = "INSERT INTO $tablename($fieldname[1],$fieldname[2]) VALUES(\"$cardid\",\"$ether\");";
        // echo $sql;
        $conn = mysqli_connect($servername,$username,$password,$db_name); 
        if($conn -> query($sql) == false)
            echo "Failed to create table ".$tablename."<br/>";
        else
            echo "Insert successful!<br/>";
    }
?>