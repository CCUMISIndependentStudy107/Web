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
    
    function WriteFileInfo($file,$name,$information,$end){  //if end == false 不換行
        if($end==false)
            fwrite($file,$name.' : '.$information."\n");
        else
            fwrite($file,$name.' : '.$information);
        return;
    }

    function ReduceC(){
        $str = floatval($_POST['product_weight'] * $_POST['product_quantity'] * 440/1000);
        return $str."公克(g)";
    }

    function WriteProductInfo(){
        date_default_timezone_set("Asia/Taipei");   //change time zone to Taipei https://www.php.net/manual/en/timezones.php
        $date = new DateTime('now');
        $date = $date->format('Y-m-d-H-i-s');   //date format
        $dest = "uploads/".$date;   //destination is named by datetime
        if(!file_exists($dest)) mkdir($dest,0777,true); //if not exists , create one
        $filename = $dest.'/ProductInfo.txt';   //write product information named ProductInfo.txt
        #Write File 
        $file = fopen($filename,"w");
        WriteFileInfo($file,"商品名稱",$_POST['product_name'],false);
        WriteFileInfo($file,"商品價格",$_POST['product_price'],false);
        WriteFileInfo($file,"商品數量",$_POST['product_quantity'],false);
        WriteFileInfo($file,"商品簡介",$_POST['product_info'],false);
        WriteFileInfo($file,"商品重量",$_POST['product_weight'],false);
        #Tag process
        $tags = $_POST['product_tag'];
        if(substr($tags,-1) == ',') $tags = substr_replace($tags,'',-1); //防呆 若,在最後面的時候
        WriteFileInfo($file,"商品標籤",$tags,false);
        WriteFileInfo($file,"商品照面",$_FILES['product_picture']['name'],false);
        #Move image to new destination
        $img_name = $_FILES['product_picture']['name'];
        $img_old_dest = "uploads/".$img_name;
        $image_new_dest = $dest.'/'.$img_name;
        rename($img_old_dest,$image_new_dest);
        WriteFileInfo($file,"節碳量",ReduceC(),true);
        //echo "OK";
        fclose($file);
    }
?>