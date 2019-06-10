<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商城</title>
    <link rel="stylesheet" href="./style.css">
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
        .card-img-top {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .form-control-plaintext {
            font-weight: bold;
        }
        .modal-xl {
            max-width: 1000px !important;
        }
    </style>
</head>
<body onload="searchCompany()">
    <!-- <button type="button"><img src=""></button> -->
    <form onsubmit="return searchCompany();" method="POST" name="Test">
        <div class="form-row mx-0">
            <div class="form-group col-md-6">
                <label for="CompanyName">請輸入廠商名稱</label>
                <input type="text" class="form-control" id="CompanyName" name="CompanyName">
            </div>
            <div class="form-group col-md-2">
                <label for="">&nbsp;</label>
                <button type="submit" class="btn btn-success" style="display: block">送出</button>
            </div>
        </div>
    </form>

    <div id="result"></div>

    <script>
        function searchCompany() {
            getProduct($('input[name="CompanyName"]').val()).then(res => {
                window.parent.SetCwinHeight();
            }).catch(err => {
                console.log('Error:', err);
            });
            return false;
        }

        function getProduct(CompanyName) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: 'Store_get_product.php',
                    type: 'POST',
                    data: {
                        CompanyName: CompanyName
                    },
                    error: function(err) {
                        reject(err);
                    },
                    success: function(res) {
                        $('#result').html(res);
                        resolve(res);
                    }
                });
            });
        }

        function purchaseProduct(id) {
            console.log('id:', id);
            let AllInfo = [id];
            for (let i = 0; i < 6; i++)
                AllInfo.push($('#product-details-' + id + ' input[type="text"]').eq(i).val());
            AllInfo.push($('#product-details-' + id + ' textarea').val().trim());
            AllInfo.push($('#buyamount' + id).val());
            AllInfo.push($('#cardID' + id).val());
            AllInfo.push($('#companyName' + id).val());
            // return new Promise((resolve, reject) => {
                $.ajax({
                    url: 'Purchase.php',
                    type: 'POST',
                    data: {
                        AllInfo: AllInfo
                    },
                    error: function(err) {
                        // reject(err);
                        console.log('Error:', err);
                    },
                    success: function(res) {
                        // resolve(res);
                        $('#productDetailModal' + id).modal('hide');
                        console.log('res:\n', res);
                    }
                });
            // });
            return false;
        }
    </script>
</body>
</html>