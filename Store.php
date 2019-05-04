<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商城</title>
</head>
<body>
    <!-- <button type="button"><img src=""></button> -->
    <form method="POST" name="Test">
        <p>廠商名稱:<input type="text" name="CompanyName" required>
        <button type="submit">送出</button></p>
    </form>
    <?php
        include "connect_sql.php";
        include "GetFieldName.php";
        if(isset($_POST["CompanyName"])){
            $companyName = $_POST["CompanyName"];
            // $tablename = "product";
            $tablename = "preprocess";
            $fieldName = GetFieldName($servername,$username,$db_name,$tablename);
            FetchSQL($servername,$username,$password,$db_name,$tablename,$fieldName,$companyName);
        }
    ?>
    <?php
        function FetchSQL($servername,$username,$password,$db_name,$tablename,$fieldName,$companyName){
        }
    ?>
</body>
</html>