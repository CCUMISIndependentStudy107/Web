<?php
    include "connect_sql.php";
    include "SQLRelative.php";
    if (isset($_POST["id"]) && isset($_POST["status"])) { // Make sure really POST variable(s)
        $id = $_POST["id"];
        $status = $_POST["status"];
        $tx = ($status == 1) ? $_POST["tx"] : "fail";
        // "$status == 1" means it is set to be an available product
        // In addition to update status in database, it IS ABOUT TO be inserted a copy into the new table, `product`
        if ($status == 1) {
            $conn = mysqli_connect($servername, $username, $password, $db_name);
            $tableName = "record";
            $sql = "UPDATE " . $tableName . " SET tx=\"" . $tx . "\",Status=".$status." WHERE ID=" . $id . ";";
            if ($conn->query($sql) === false)
                echo "Failed to update STATUS.";
            else
                echo "Record updated successfully.";
        }
        // Close connection
        mysqli_close($conn);
    }
    else {
        // Catch error
        header("Location: Order.php", true, 301);
        exit();
    }
?>