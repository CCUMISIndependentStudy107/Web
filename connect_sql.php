<?php
$servername = "140.123.94.145";
$username = "zhbot";
$password = "zhbot107";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) die("Connection failed: " . mysqli_connect_error());
echo "Connected successfully";
?> 