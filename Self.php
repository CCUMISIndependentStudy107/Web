<?php
    include "connect_sql.php";
    include "SQLRelative.php";
    if (isset($_POST['username'])){
        $name = $_POST['username'];
        // $name = 'zhbot';
        $eth = getEthernet($servername,$username,$password,$db_name,$name);
        echo $eth;
    }
?>

<?php
    function getEthernet($servername,$username,$password,$db_name,$name){
        $member_table = "member";
        $member_fieldname = GetFieldName($servername, $username, $password, $db_name, $member_table);
        // print_r($member_fieldname);
        //[0] => ID [1] => name [2] => CardID [3] => Ether [4] => HDC
        $sql = "SELECT ".$member_table.".".$member_fieldname[3]." FROM ".$member_table." WHERE ".$member_table.".".$member_fieldname[1]."=\"".$name."\";";
        // echo $sql;
        $conn = mysqli_connect($servername, $username, $password, $db_name);
        $eth;
        if ($res = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    $eth = $row[$member_fieldname[3]];
                }
            }
            else {
                echo "No result!<br/>";
                return ;
            }
            mysqli_free_result($res);
        }
        // print($eth);
        return $eth;
    }
?>