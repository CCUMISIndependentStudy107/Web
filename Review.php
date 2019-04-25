<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>產品審查</title>
    </head>
    <body>
        <p>輸入關鍵字:<input type="text" name="search" value="">
        <input type="submit" name="button" value="送出"></p>
        <?php
            include "connect_sql.php";
            $ProductInfoName = array("ID","Name","Price","Quantity","Information","Weight","Tag","PictureName","ReduceC","FolderName","Company");
            $tableName = 'preprocess';
            $sql = "SELECT * FROM ".$tableName." ";
            // echo $sql;
            $data = mysql_query($sql);
            for($i=1;$i<=mysql_num_rows($data);$i++) $resarr = mysql_fetch_row($data);
            for($i=0;$i<count($resarr);$i++) echo $resarr[$i]."<br/>";
        ?>
    </body>
</html>