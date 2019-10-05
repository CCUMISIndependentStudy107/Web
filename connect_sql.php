<?php
    $servername = "127.0.0.1"; //server 本地可用localhost
    $username = "root";    //sql 帳號
    $password = ""; //sql 密碼
    /* CREATE DATABASE IF NOT EXISTS */
    $db_name = "newzhbot";  //database name
    $conn = mysqli_connect($servername, $username, $password);  // Create connection
    $db_link = mysql_pconnect($servername, $username, $password);
    mysql_select_db($db_name, $db_link);
    mysql_query("SET NAMES utf8;", $db_link);   //utf8 or big5
    if (!$conn) die("Connection failed: " . mysqli_connect_error()."<br/>");    //not connected then die
    // else echo "Connection Success!";
    $sql = "CREATE DATABASE IF NOT EXISTS ".$db_name." DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;";    //utf8 utf8_unicode_ci or big5 big5_chinese_ci
    if($conn -> query($sql) == false) echo "Failed to create database<br/>";
    // else echo "Database create successfully!<br/>";
    $conn = mysqli_connect($servername,$username,$password,$db_name);
?>