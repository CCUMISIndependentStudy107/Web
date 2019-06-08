<?php
    include "Beta_table.php";
    ImageCheck();
    $value = BetaCalculate();
    $date = WriteProductInfo();
    $filename = "beta.txt";
    BetaText($filename,$date,$value);
    die();
    echo "Upload Successful";
?>
<html>
    <head>
        <title>上傳頁面</title>
        <meta charset="UTF-8" http-equiv="refresh" content="1;url=<?php $url = "connect_zhbot.php"; echo $url; ?>">
    </head>
    <body>
    </body>
</html>
<?php
    function ImageCheck(){
        # 檢查檔案是否上傳成功
        if ($_FILES['product_picture']['error'] === UPLOAD_ERR_OK){
            $filetype = $_FILES['product_picture']['type'];
            if(!file_exists('uploads')) mkdir('uploads',0777,true); //0777 is already the default mode for directories and may still be modified by the current umask.
            $upload_folder = 'uploads/';
            if(IsImage($filetype)){
                # 檢查檔案是否已經存在
                if (file_exists($upload_folder . $_FILES['product_picture']['name'])) echo '檔案已存在。<br/>';
                else{
                    $file = $_FILES['product_picture']['tmp_name'];
                    $dest = $upload_folder . $_FILES['product_picture']['name'];
                    move_uploaded_file($file, $dest);   //將檔案移至指定位置
                }
            }
        }
        else
            echo '錯誤代碼：' . $_FILES['product_picture']['error'] . '<br/>';
    }

    function IsImage($filetype){
        $acceptable_file_ext = "image";
        if(strpos($filetype,$acceptable_file_ext) !== false) return true;
        return false;
    }

    function WriteFileInfo($file,$name,$information,$end){  //if end == false 不換行
        if($end==false) fwrite($file,$name.' : '.$information."\n");
        else fwrite($file,$name.' : '.$information);
        return;
    }

    function WritePlainText($file,$information,$end,$date){
        if(!$end) fwrite($file,$information."\n");   //seperate by NextLine
        else{
            fwrite($file,$information);
            MovePlainText($date);
        }
    }

    function MovePlainText($date){
        $filename = "PlainInfo.html";
        $upload_folder = "uploads/";
        copy($upload_folder.$date."/".$filename,$upload_folder."/".$filename);
    }

    function ReduceC(){
        return (floatval($_POST['product_weight'] * $_POST['product_quantity'] * 440/1000));
    }

    function WriteProductInfo(){
        #DateTime
        date_default_timezone_set("Asia/Taipei");   //change time zone to Taipei https://www.php.net/manual/en/timezones.php
        $date = new DateTime('now');
        $date = $date->format('Y-m-d-H-i-s');   //date format
        $dest = "uploads/".$date;   //destination is named by datetime
        // $dest = "uploads/".$_POST['product_name'];
        if(!file_exists($dest)) mkdir($dest,0777,true); //if not exists , create one
        $info_filename = $dest.'/ProductInfo.txt';   //write product information text file named ProductInfo.txt
        $plain_filename = $dest.'/PlainInfo.html';   //write plain information text file named PlainInfo.html
        #Write info File
        $info_file = fopen($info_filename,"w");
        WriteFileInfo($info_file,"商品名稱",$_POST['product_name'],false);
        WriteFileInfo($info_file,"商品價格",$_POST['product_price'],false);
        WriteFileInfo($info_file,"商品數量",$_POST['product_quantity'],false);
        WriteFileInfo($info_file,"商品簡介",$_POST['product_info'],false);
        WriteFileInfo($info_file,"商品重量",$_POST['product_weight'],false);
        #Tag process
        $tags = $_POST['product_tag'];
        if(substr($tags,-1) == ',') $tags = substr_replace($tags,'',-1); //防呆 若,在最後面的時候
        WriteFileInfo($info_file,"商品標籤",$tags,false);
        WriteFileInfo($info_file,"商品照片",$_FILES['product_picture']['name'],false);
        WriteFileInfo($info_file,"節碳量",ReduceC()."公克(g)",false);
        WriteFileInfo($info_file,"廠商名稱",$_POST['company_name'],true);
        #Write plain File
        $plain_file = fopen($plain_filename,"w");
        WritePlainText($plain_file,$_POST['product_name'],false,$date);
        WritePlainText($plain_file,$_POST['product_price'],false,$date);
        WritePlainText($plain_file,$_POST['product_quantity'],false,$date);
        WritePlainText($plain_file,$_POST['product_info'],false,$date);
        WritePlainText($plain_file,$_POST['product_weight'],false,$date);
        WritePlainText($plain_file,$tags,false,$date);
        WritePlainText($plain_file,$_FILES['product_picture']['name'],false,$date);
        WritePlainText($plain_file,ReduceC(),false,$date);
        WritePlainText($plain_file,$date,false,$date);
        WritePlainText($plain_file,$_POST['company_name'],true,$date);
        #Move image to new destination
        $img_name = $_FILES['product_picture']['name'];
        $img_old_dest = "uploads/".$img_name;
        $image_new_dest = $dest.'/'.$img_name;
        rename($img_old_dest,$image_new_dest);
        //echo "OK";
        fclose($info_file);
        return $date;
    }

    function BetaText($filename,$date,$value){
        $beta = fopen($filename,"w");
        WritePlainText($beta,$value,true,$date);
    }
?>