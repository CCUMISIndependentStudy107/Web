<?php
    // header("Content-Type:text/html; charset=big5");
    /* for ($i = 0; $i < count($_POST['AllInfo']); $i++)
        echo $_POST['AllInfo'][$i] . ",";*/
    //[0]=>名稱 [1]=>標籤 [2]=>節碳量 [3]=>單價 [4]=>數量 [5]=>重量 [6]=>資訊 [7]=>購買數量
    // $file = "http://140.123.94.145/zhbot/myText.txt";
    // $file2 = "http://localhost/myText.txt";
    // $f = fopen($file,"r");
    // iconv("UTF-8","gbk//TRANSLIT",$f);
    // $str = "";
    // while(!feof($f)){
    //     $str .= fgets($f);
    // }
    $ProductChineseName = array("名稱","標籤","節碳量","單價","數量","重量","資訊","購買數量");
    $product = array();
    for($i=0;$i<count($_POST['AllInfo']);$i++) array_push($product,$_POST['AllInfo'][$i]);
    print_r($product);
    writeInfo($ProductChineseName,$product);
    /*$url='http://140.123.94.145/zhbot/myText.html';
    $html= file_get_contents($url);
    echo $html;
    // fclose($f);
    // myPrint($str);
    myPrint($html);*/
    // echo $str;
?>
<?php
    // header("Content-Type:text/html; charset=big5");
    function writeInfo($title,$product){
        $filename = "print.html";
        $file = fopen($filename,"w");
        for($i=0;$i<count($title);$i++) fwrite($file,$title[$i].":".$product[$i]." \n");
        fclose($file);
    }
    function myPrint($str){
        $printer = "WP-K617 Ver.3.10";
        $ph = printer_open($printer);
        // $content = "print chinese use BIG5!";
        printer_write($ph, $str);
        printer_close($ph);
    }
?>