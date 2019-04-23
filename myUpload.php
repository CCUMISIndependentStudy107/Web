<?php
    include "connect_sql.php";  //connect to mysql
    // $wordpress_upload_url = 'http://140.123.94.145/bamboo/wp-admin/post-new.php?post_type=product';
    /* product information from the form */
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $product_info = $_POST['product_info'];
    $product_weight = $_POST['product_weight'];
    /* image upload */
    # 檢查檔案是否上傳成功
    if ($_FILES['product_picture']['error'] === UPLOAD_ERR_OK){
        $filetype = $_FILES['product_picture']['type'];
        if(!file_exists('uploads')) mkdir('uploads',0777,true); //0777 is already the default mode for directories and may still be modified by the current umask.
        $upload_folder = 'uploads/';
        echo '檔案名稱: ' . $_FILES['product_picture']['name'] . '<br/>';
        echo '檔案類型: ' . $_FILES['product_picture']['type'] . '<br/>';
        echo '檔案大小: ' . ($_FILES['product_picture']['size'] / 1024) . ' KB<br/>';
        echo '暫存名稱: ' . $_FILES['product_picture']['tmp_name'] . '<br/>';
        if(isImage($filetype)){
            # 檢查檔案是否已經存在
            if (file_exists($upload_folder . $_FILES['product_picture']['name'])){
                echo '檔案已存在。<br/>';
            }
            else {
                $file = $_FILES['product_picture']['tmp_name'];
                $dest = $upload_folder . $_FILES['product_picture']['name'];
                # 將檔案移至指定位置
                move_uploaded_file($file, $dest);
            }
        }
    } 
    else{
        echo '錯誤代碼：' . $_FILES['product_picture']['error'] . '<br/>';
    }
    $filename = 'test.txt';
    $file = fopen($filename,"w");
    WriteFileInfo($file,"商品名稱",$product_name,false);
    WriteFileInfo($file,"商品價格",$product_price,false);
    WriteFileInfo($file,"商品數量",$product_quantity,false);
    WriteFileInfo($file,"商品簡介",$product_info,false);
    WriteFileInfo($file,"商品重量",$product_weight,false);
    WriteFileInfo($file,"商品照面",$_FILES['product_picture']['name'],true);
    fclose($file);
?>

<?php
    function isImage($filetype){
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
?>