<?php
    include "connect_sql.php";  //connect to mysql
    $wordpress_upload_url = 'http://140.123.94.145/bamboo/wp-admin/post-new.php?post_type=product';
    /* product information from the form */
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_name'];
    $product_quantity = $_POST['product_quantity'];
    $product_info = $_POST['product_info'];
    $product_weight = $_POST['product_weight'];
    /* image upload */
    # 檢查檔案是否上傳成功
    if ($_FILES['product_picture']['error'] === UPLOAD_ERR_OK){
        $filename = $_FILES['product_picture']['name'];
        $upload_folder = 'uploads/';
        echo '檔案名稱: ' . $_FILES['product_picture']['name'] . '<br/>';
        echo '檔案類型: ' . $_FILES['product_picture']['type'] . '<br/>';
        echo '檔案大小: ' . ($_FILES['product_picture']['size'] / 1024) . ' KB<br/>';
        echo '暫存名稱: ' . $_FILES['product_picture']['tmp_name'] . '<br/>';
        if(isImage($filename)){
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
?>

<?php
    function isImage($filename){
        $acceptable_file_ext = array(".jpg",".png",".jpeg",".gif"); //jpg png gif are acceptable
        for($i = 0; $i < count($acceptable_file_ext); $i++)
            if(strpos($filename,$acceptable_file_ext[$i]) == true) return true;
        return false;
    }
?>