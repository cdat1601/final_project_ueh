<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Quản lý đơn hàng</title>
    <!--bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!--google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <!--link style-->
    <link rel="stylesheet" href="public/styles/templates.css">
    <link rel="stylesheet" href="public/styles/admin.css">
    <link rel="stylesheet" href="public/styles/account.css">

</head>

<body>
    <style>
        #btnqldh {
            border-radius: 15px;
            border: none;
            text-align: left;
            height: 100%;
            width: 100%;
            background-color: #000000;
            color: #FFF;
        }
    </style>
    <?php
        include_once("private/controllers/qlydonhang_controller.php");
        $qlyDonHangController = new QuanLyDonHangController();
        $qlyDonHangController->LoadPage();
        ?>
            </div>
        </div>
    </div>
    <script src='public/scripts/admin.js'></script>
</body>

</html>