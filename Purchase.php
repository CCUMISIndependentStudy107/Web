<?php
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
?>