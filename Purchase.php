<?php
    include "connect_sql.php";
    $ProductChineseName = array("�W��","����","�`�Ҷq","���","�ƶq","���q","��T","�ʶR�ƶq");
    $ProductEnglishName = array("Name","Tag","ReduceC","Price","Quantity","Weight","Information","Purchase Quantity");
    $product = array();
    for($i=0;$i<count($_POST['AllInfo']);$i++){
        $str = mb_convert_encoding($_POST['AllInfo'][$i], "BIG5", "UTF-8"); //��l�s�X��BIG5��UTF-8
        array_push($product,$str);
    }
    $id = $product[0];
    $quantity = $product[5];
    // print_r($product);
    // [0]=> ID [1]=>�W�� [2]=>���� [3]=>�`�Ҷq [4]=>��� [5]=>�ƶq [6]=>���q [7]=>��T [8]=>�ʶR�ƶq [9]=>�d��
    if(Judge($conn,$id,$quantity)){
        $filename = "print.html";
        writeInfo($ProductChineseName,$product,$filename);
        // writeInfo($ProductEnglishName,$product,$filename);
        $url='http://140.123.94.145/web/'.$filename;
        $html = file_get_contents($url);
        // echo $html;
        SQLDeletion($conn,$id,$quantity);
        myPrint($html);
    }
    else{
        echo "�ƶq����";
    }
?>
<?php
    // header("Content-Type:text/html; charset=big5");
    function writeInfo($title,$product,$filename){
        $file = fopen($filename,"w");
        for($i=1;$i<count($title);$i++) {
            if($i == 5) continue;   //Stored Quantity
            if($i == 7) fwrite($file,$title[$i].":".$product[$i]);  //information has one more \n
            else fwrite($file,$title[$i].":".$product[$i]."\n");
        }
        fwrite($file,"�`�p : ".$product[4]*$product[8]." ��");
        fclose($file);
    }

    function myPrint($str){
        $printer = "WP-K617 Ver.3.10";
        $ph = printer_open($printer);
        // $content = "print chinese use BIG5!";
        $print = "�p�˦P��\n=========\n".$str."\n=========";
        printer_write($ph, $print);
        printer_close($ph);
    }

    function Judge($conn,$id,$quantity){
        $tablename = "preprocess";
        $sql = "SELECT Quantity From $tablename WHERE ID = $id";
        $sqlQuantity;
        if ($res = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    $sqlQuantity = $row[$fieldName[$i]];
                }
            }
            else {
                echo "No result!<br/>";
                return ;
            }
            mysqli_free_result($res);
        }
        if($sqlQuantity<$quantity) return false;
        return true;
    }

    function SQLDeletion($conn,$id,$quantity){
        $tablename = "preprocess";
        $sql = "UPDATE $tablename SET Quantity = (Quantity-$quantity) WHERE ID = $id;";
        if($conn -> query($sql) == false){
            echo "Failed to update values <br/>";
        }
        else{
            echo "���\��J�ܸ�Ʈw�I<br/>";
        }
        mysqli_close($conn);
    }
?>