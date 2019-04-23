<?php
$servername = "140.123.94.145"; //server 本地可用localhost
$username = "zhbot";    //sql 帳號
$password = "zhbot107"; //sql 密碼
// Create connection
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) die("Connection failed: " . mysqli_connect_error()."<br/>");    //not connected then die
// not die then good (Y)
?> 