<!DOCTYPE html>
<html lang="en">
<head>
    <title>註冊</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <form action="register.php" method="POST">
        <p>會員卡號 : <input name="CardID" type="text" required></p>
        <p>乙太坊地址 : <input name="Ether" type="text" required></p>
        <button type="submit">送出</button>
        <button type="reset">重設</button>
    </form>
    <input type ="button" onclick="history.back()" value="回到上一頁"></input>
    <?php
        include "connect_sql.php";
        echo "<br/>";
        if(isset($_POST['CardID']) && isset($_POST['Ether'])){
            $cardID = $_POST['CardID'];
            if(is_numeric($cardID)){
                $ether = $_POST['Ether'];
                $fieldname = array("ID","CardID","Ether");
                $tableName = CreateMemberTable($servername,$username,$password,$db_name,$fieldname);
                if(DuplicateMember($servername,$username,$password,$db_name,$tableName,$fieldname,$cardID,$ether) == false){
                    InsertMember($servername,$username,$password,$db_name,$tableName,$fieldname,$cardID,$ether);
                }
                else
                    echo "註冊失敗 : 卡號或以太坊位置重複註冊!<br/>";
            }
            else{
                echo "註冊失敗 : 卡號請用純數字代表!<br/>";
            }
        }
    ?>
</body>
</html>

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

    function DuplicateMember($servername,$username,$password,$db_name,$tablename,$fieldname,$cardID,$Ether){
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        $sql = "SELECT * FROM ".$tablename." ";
        $arr = array();
        $cardid = array();
        $ether = array();
        $fieldnum = count($fieldname);
        if($res = mysqli_query($conn, $sql)){
            while($row = mysqli_fetch_array($res)){
                for($i=0,$j=0;$i<$fieldnum;$i++){
                    // echo "<td>" . $row[$fieldname[$i]] . "</td><br/>";
                    $id = $row[$fieldname[0]];
                    if($i>0) $arr[$id][$j++]=$row[$fieldname[$i]];
                }
            }
        }
        // print_r($arr);
        $keys = array_keys($arr);
        // print_r($keys);
        for($i=0;$i<count($keys);$i++){
            array_push($cardid,$arr[$keys[$i]][0]);
            array_push($ether,$arr[$keys[$i]][1]);
        }
        $result = (findDuplicate($cardID,$cardid) || findDuplicate($Ether,$ether));
        return $result;
    }

    function InsertMember($servername,$username,$password,$db_name,$tablename,$fieldname,$cardid,$ether){
        $sql = "INSERT INTO $tablename($fieldname[1],$fieldname[2]) VALUES(\"$cardid\",\"$ether\");";
        // echo $sql;
        $conn = mysqli_connect($servername,$username,$password,$db_name);
        if($conn -> query($sql) == false)
            echo "Failed to create table ".$tablename."<br/>";
        else
            echo "註冊成功!<br/>";
    }

    function FindDuplicate($key,$array){
        for($i=0;$i<count($array);$i++)
            if($key == $array[$i]) return true;
        return false;
    }
?>