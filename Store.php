<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商城</title>
    <script src="https://code.jquery.com/jquery-3.4.0.js" integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <style>
        .card {
            cursor: pointer;
            transition: .2s;
        }

        .card:hover {
            filter: brightness(.95);
        }
    </style>
</head>
<body>
    <!-- <button type="button"><img src=""></button> -->
    <form method="POST" name="Test">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="CompanyName">廠商名稱</label>
                <input type="text" class="form-control" id="CompanyName" name="CompanyName" required>
            </div>
            <div class="form-group col-md-2">
                <label for="">&nbsp;</label>
                <button type="submit" class="btn btn-success" style="display: block">送出</button>
            </div>
        </div>
    </form>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="card text-center mx-1 my-3" data-toggle="modal" data-target="#productDetailModal">
                    <img class="card-img-top border-bottom" src="uploads/2019-05-04-20-12-06/1.jpg" alt="Success Upload products">
                    <div class="card-body">
                        <h5 class="card-title">Name - leaf13</h5>
                    </div>
                    <div class="card-footer text-muted">
                        ReduceC
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="productDetailModal" tabindex="-1" role="dialog" aria-labelledby="productDetailModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">更多資訊</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="name" class="col-sm-1 col-form-label">名稱</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="name" value="Name">
                        </div>
                        <label for="tag" class="col-sm-1 col-form-label">標籤</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="tag" value="tag">
                        </div>
                        <label for="price" class="col-sm-1 col-form-label">單價</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="price" value="Price">
                        </div>
                        <label for="quantity" class="col-sm-1 col-form-label">數量</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="quantity" value="quantity">
                        </div>
                        <label for="weight" class="col-sm-1 col-form-label">重量</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="weight" value="weight">
                        </div>
                        <label for="information" class="col-sm-1 col-form-label">資訊</label>
                        <div class="col-sm-11">
                            <textarea readonly class="form-control-plaintext" id="information">information</textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


    <?php
        include "connect_sql.php";
        include "GetFieldName.php";
        if (isset($_POST["CompanyName"])) {
            $companyName = $_POST["CompanyName"];
            // $tablename = "product";
            $tablename = "preprocess";
            $fieldName = GetFieldName($servername, $username, $password, $db_name, $tablename);
            FetchSQL($servername, $username, $password, $db_name, $tablename, $fieldName, $companyName);
        }

        function FetchSQL($servername, $username, $password, $db_name, $tablename, $fieldName, $companyName) {
            // print_r($fieldName);
            //[0] => ID [1] => Name [2] => Price [3] => Quantity [4] => Information [5] => Weight [6] => Tag
            //[7] => PictureName [8] => ReduceC [9] => FolderName [10] => Company [11] => tx [12] => checks
            $conn = mysqli_connect($servername, $username, $password, $db_name);
            if (!$conn)
                die("Connection failed: " . mysqli_connect_error() . "<br/>");
            $sql = "SELECT * FROM $tablename WHERE $fieldName[10] = \"$companyName\" AND $fieldName[12] = 1";
            if ($conn -> query($sql) == false) {
                echo "There is no result where company = $companyName<br/>";
            }
            else {
                $fieldnum = count($fieldName);
                if ($res = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_array($res)) {
                            for ($i = 0, $j = 0; $i < $fieldnum; $i++) {
                            // echo "<td>" . $row[$fieldname[$i]] . "</td><br/>";
                                $id = $row[$fieldName[0]];
                                $arr[$id][$j++] = $row[$fieldName[$i]];
                            }
                        }
                    }
                    else {
                        echo "No result!<br/>";
                        return ;
                    }
                    mysqli_free_result($res);
                }
                $keys = array_keys($arr);
                // print_r($keys);
                for ($i = 0; $i < count($keys); $i++) {
                    $path = "uploads/";
                    echo "<div><button type=\"button\"><img src=\"".$path.$arr[$keys[$i]][9]."/".$arr[$keys[$i]][7]."\">".$arr[$keys[$i]][1]."</button></div>";  //print 1=name 9=folder 7=pic
                }
            }
        }
    ?>
</body>
</html>