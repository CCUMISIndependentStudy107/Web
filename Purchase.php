<?php
    // header("Content-Type:text/html; charset=utf-8");
    /* for ($i = 0; $i < count($_POST['AllInfo']); $i++)
        echo $_POST['AllInfo'][$i] . ",";*/
    //[0]=>???ç¨? [1]=>æ¨?ç±? [2]=>ç¯?ç¢³é?? [3]=>??®å?? [4]=>??¸é?? [5]=>?????? [6]=>è³?è¨? [7]=>è³¼è²·??¸é??
    // $file = "http://140.123.94.145/zhbot/myText.txt";
    // $file2 = "http://localhost/myText.txt";
    // $f = fopen($file,"r");
    // iconv("UTF-8","gbk//TRANSLIT",$f);
    // $str = "";
    // while(!feof($f)){
    //     $str .= fgets($f);
    // }
    // $ProductChineseName = array("???ç¨?","æ¨?ç±?","ç¯?ç¢³é??","??®å??","??¸é??","??????","è³?è¨?","è³¼è²·??¸é??");
    $ProductChineseName = array("¦WºÙ","¼ÐÅÒ","¸`ºÒ¶q","³æ»ù","¼Æ¶q","­«¶q","¸ê°T","ÁÊ¶R¼Æ¶q");
    $ProductEnglishName = array("Name","Tag","ReduceC","Price","Quantity","Weight","Information","Purchase Quantity");
    $product = array();
    for($i=0;$i<count($_POST['AllInfo']);$i++) array_push($product,$_POST['AllInfo'][$i]);
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
            fwrite($file,$title[$i].":".$product[$i]." \n");
        }
        fwrite($file,"Total : ".$product[3]*$product[7]);
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