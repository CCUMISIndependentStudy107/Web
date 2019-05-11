<?php
    include "connect_sql.php";
    // header("Content-Type:text/html; charset=utf-8");
    /* for ($i = 0; $i < count($_POST['AllInfo']); $i++)
        echo $_POST['AllInfo'][$i] . ",";*/
    //[0]=>???蝔? [1]=>璅?蝐? [2]=>蝭?蝣喲?? [3]=>??桀?? [4]=>??賊?? [5]=>?????? [6]=>鞈?閮? [7]=>鞈潸眺??賊??
    // $file = "http://140.123.94.145/zhbot/myText.txt";
    // $file2 = "http://localhost/myText.txt";
    // $f = fopen($file,"r");
    // iconv("UTF-8","gbk//TRANSLIT",$f);
    // $str = "";
    // while(!feof($f)){
    //     $str .= fgets($f);
    // }
    // $ProductChineseName = array("???蝔?","璅?蝐?","蝭?蝣喲??","??桀??","??賊??","??????","鞈?閮?","鞈潸眺??賊??");
    $ProductChineseName = array("名稱","標籤","節碳量","單價","數量","重量","資訊","購買數量");
    $ProductEnglishName = array("Name","Tag","ReduceC","Price","Quantity","Weight","Information","Purchase Quantity");
    $product = array();
    for($i=0;$i<count($_POST['AllInfo']);$i++){
        $str = mb_convert_encoding($_POST['AllInfo'][$i], "BIG5", "UTF-8"); //原始編碼為BIG5轉UTF-8
        array_push($product,$str);
    }
    // print_r($product);
    // 0 "名稱" 1 "標籤" 2 "節碳量" 3 "單價" 4 "數量" 5 "重量" 6 "資訊" 7 "購買數量"
    if(Judge($conn,$id,$product[4])){
        $filename = "print.html";
        // writeInfo($ProductChineseName,$product,$filename);
        // writeInfo($ProductEnglishName,$product,$filename);
        // $url='http://140.123.94.145/web/'.$filename;
        $url = 'http://localhost/web/'.$filename;
        $html = file_get_contents($url);
        echo $html;
        // fclose($f);
        // myPrint($str);
        myPrint($html);
        // echo $str;
    }
    else{
        echo "數量不足";
    }
?>
<?php
    // header("Content-Type:text/html; charset=big5");
    function writeInfo($title,$product,$filename){
        $file = fopen($filename,"w");
        for($i=0;$i<count($title);$i++) {
            if($i == 4) continue;
            if($i == 6) fwrite($file,$title[$i].":".$product[$i]);  //information has one more \n
            else fwrite($file,$title[$i].":".$product[$i]."\n");
        }
        fwrite($file,"總計 : ".$product[3]*$product[7]." 元");
        fclose($file);
    }

    function myPrint($str){
        $printer = "WP-K617 Ver.3.10";
        $ph = printer_open($printer);
        // $content = "print chinese use BIG5!";
        $print = "小竹同學\n=========\n".$str."\n=========";
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
            echo "成功輸入至資料庫！<br/>";
        }
        mysqli_close($conn);
    }
?>