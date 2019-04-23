<?php
    include "connect_sql.php";  //connect to mysql
    ImageCheck();
    WriteProductInfo();
?>

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
    
    function WriteFileInfo($file,$name,$information,$end){
        if($end==false)
            fwrite($file,$name.' : '.$information."\n");
        else
            fwrite($file,$name.' : '.$information);
        return;
    }

    function WriteProductInfo(){
        $filename = 'test.txt';
        $file = fopen($filename,"w");
        WriteFileInfo($file,"商品名稱",$_POST['product_name'],false);
        WriteFileInfo($file,"商品價格",$_POST['product_price'],false);
        WriteFileInfo($file,"商品數量",$_POST['product_quantity'],false);
        WriteFileInfo($file,"商品簡介",$_POST['product_info'],false);
        WriteFileInfo($file,"商品重量",$_POST['product_weight'],false);
        WriteFileInfo($file,"商品照面",$_FILES['product_picture']['name'],true);
        //echo "OK";
        fclose($file);
    }
?>