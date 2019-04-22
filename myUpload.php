<?php
    include "connect_sql.php";  //connect to mysql
    /* product information from the form */
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_name'];
    $product_quantity = $_POST['product_quantity'];
    $product_info = $_POST['product_info'];
    $product_weight = $_POST['product_weight'];
    /* keep it to an array */
    $product = array(
        name => $product_name,
        price => $product_price,
        quantity => $product_quantity,
        info => $product_info,
        weight => $product_weight
    );
    /* file upload */
    $upload_path = 'uploads/';
    
?>