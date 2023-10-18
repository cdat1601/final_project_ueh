<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <!--bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <!--link style-->
    <link rel="stylesheet" href="public/styles/templates.css">
    <link rel="stylesheet" href="public/styles/footer.css">
    <link rel="stylesheet" href="public/styles/trangchu.css">
</head>

<body>
    <header>
        <?php
        include_once("public/templates/header.php");
        ?>
    </header>
    <div class="container-fluid">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">

            <?php
            require_once("private/controllers/trangchu_controller.php");
            $trangChuController = new TrangChuController();
            $trangChuController->LoadSlider();
            ?>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>



    <div class="container">

        <!--New Arrivals-->
        <div class="heading">
            <h2 class="text-uppercase">New arrrivals</h2>
            <a class="more" href="./?to=search&amp;from=another&amp;name=xemthem&amp;value=moi">Xem thêm</a>
        </div>
        <div class="row pro-list">
            <?php
            require_once("private/controllers/trangchu_controller.php");
            $trangChuController = new TrangChuController();
            $trangChuController->LoadNewArrivals(8);
            ?>
        </div>

        <!--Hot Sale-->
        <div class="heading">
            <h2 class="text-uppercase">Hot Sale</h2>
            <a class="more" href="./?to=search&from=another&name=xemthem&value=hotsale">Xem thêm</a>
        </div>
        <div class="row pro-list">
            <?php
            require_once("private/controllers/trangchu_controller.php");
            $trangChuController = new TrangChuController();
            $trangChuController->LoadHotSale(8);
            ?>
        </div>
        <!---->
        <div class="heading">
            <h2 class="text-uppercase">Hot Accessories</h2>
            <a class="more" href="/?to=search&from=self&danhmuc%5B%5D=6">Xem thêm</a>
        </div>
        <div class="row pro-list">
            <?php
            require_once("private/controllers/trangchu_controller.php");
            $trangChuController = new TrangChuController();
            $trangChuController->LoadOthers(8);
            ?>
        </div>
    </div>

    <?php
            require_once("private/controllers/trangchu_controller.php");
            $trangChuController = new TrangChuController();
            $trangChuController->LoadBottomBanner();
            ?>
    <footer>
        <?php
        include_once("public/templates/footer.php");
        ?>
    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="public/scripts/templates.js"></script>
</body>

</html>