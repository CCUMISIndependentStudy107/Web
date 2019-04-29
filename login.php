<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>會員登入</title>
</head>
<body>
    <form method="post" name="login">
        <p>會員卡號:<input type="text" name="CardID">
        <button name="submit">登入</button></p>
    </form>
    <input type ="button" onclick="javascript:location.href='register.html'" value="註冊"></input>
    <?php
        include "connect_sql.php";
        if(isset($_POST['CardID'])){
            $cardid = $_POST['CardID'];
            $status = CheckCard($servername,$username,$password,$db_name,$cardid);
            if($status == true){
                //登入成功
                echo "Successful";
            }
            else
                echo "查無卡號";
        }
    ?>
    <?php
        function CheckCard($servername,$username,$password,$db_name,$cardid){
            $conn = mysqli_connect($servername,$username,$password,$db_name);
            $tablename = "member";
            $card_fieldname = "CardID";
            $sql = "SELECT * FROM $tablename WHERE $card_fieldname = $cardid";
            if($res = mysqli_query($conn, $sql)){
                if($row = mysqli_fetch_array($res)) return true;
            }
            return false;
        }
    ?>
</body>
</html>