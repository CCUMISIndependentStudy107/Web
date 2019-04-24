<?php
    $servername = "140.123.94.145"; //server 本地可用localhost
    $username = "zhbot";    //sql 帳號
    $password = "zhbot107"; //sql 密碼
    /* CREATE DATABASE IF NOT EXISTS */
    $db_name = "newzhbot";  //database name
    $conn = mysqli_connect($servername, $username, $password);  // Create connection
    $db_link = mysql_pconnect($servername, $username, $password);
    mysql_select_db($db_name, $db_link);
    mysql_query("SET NAMES utf8;", $db_link);
    if (!$conn) die("Connection failed: " . mysqli_connect_error()."<br/>");    //not connected then die
    // else echo "Connection Success!";
    $sql = "CREATE DATABASE IF NOT EXISTS ".$db_name." DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
    if($conn -> query($sql) == false) echo "Failed to create database<br/>";
    // else echo "Database create successfully!<br/>";
?> 