<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm sản phẩm</title>
    <!--bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!--google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <!--link style-->
    <link rel="stylesheet" href="public/styles/templates.css">
    <link rel="stylesheet" href="public/styles/footer.css">
    <link rel="stylesheet" href="public/styles/ketquatimkiem.css">
</head>

<body>
    <header>
        <?php
        include_once("public/templates/header.php");
        ?>
    </header>

    <div class="container">
        <!--breadcrumb-->

        <nav style="background-color:#F8F8F8" aria-label="breadcrumb">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./?to=home">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="to">Tất cả sản phẩm</li>
                </ol>
            </div>
        </nav>
        <!--CONTENT-->

        <div class="container">

            <!--TIỀU ĐỀ-->
            <div class="row">
                <div class="col">
                    <div class="heading">
                        <h2>Tất cả sản phẩm</h2>
                    </div>
                </div>
            </div>

            <!--BỘ LỌC-->
            <div class="row">
                <div class="col-lg-3">
                    <div class="d-xxl-none d-xl-none d-lg-none filter-heading filter-control" onClick="filtertoogle(this)">
                        <span class="">Bộ lọc sản phẩm ▼</span>
                    </div>
                    <form action="./" method="get" id="filter">
                        <input type="hidden" name="to" value="search">
                        <input type="hidden" name="from" value="self">

                        <div class="filter">
                            <div class="filter-brands">
                                <span class="filter-select">Danh mục</span>
                                <span class="filter-control filter-select" onClick="filterbrandtoggle(this)">-</span>
                                <ul id="filter-brand-items">
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="danhmuc[]" value="2" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Áo khoác
                                        </label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="danhmuc[]" value="1" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Áo sơ mi
                                        </label>
                                    </li>

                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="danhmuc[]" value="0" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Áo thun
                                        </label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="danhmuc[]" value="3" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Quần jean
                                        </label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="danhmuc[]" value="5" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Quần short
                                        </label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="danhmuc[]" value="4" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Quần tây
                                        </label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="danhmuc[]" value="6" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Khác
                                        </label>
                                    </li>


                                </ul>
                            </div>
                            <div class="filter-price">
                                <span class="filter-select">Giá</span>
                                <span class="filter-control filter-select" onClick="filterpricetoggle(this)">-</span>
                                <ul id="filter-price-items">
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="gia[]" value=" < 500000 " id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Dưới 500,000₫
                                        </label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="gia[]" value="BETWEEN 500000 AND 1000000" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            500,000₫ - 1,000,000₫
                                        </label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="gia[]" value="BETWEEN 1000000 AND 3500000" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            1,000,000₫ - 3,500,000₫
                                        </label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="gia[]" value="BETWEEN 3500000 AND 5000000" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            3,500,000₫ - 5,000,000₫
                                        </label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="checkbox" name="gia[]" value=" > 5000000" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Trên 5,000,000₫
                                        </label>
                                    </li>


                                </ul>
                            </div>
                            <div class="filter-size">
                                <span class="filter-select">Kích thước</span>
                                <span class="filter-control filter-select" onClick="filtersizetoggle(this)">-</span>
                                <ul id="filter-size-items">
                                    <li>
                                        <input type="checkbox" class="size-selector" name="size[]" value="XS" id="XS" autocomplete="off">
                                        <label class="size-btn" for="XS">XS</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" class="size-selector" name="size[]" value="S" id="S" autocomplete="off">
                                        <label class="size-btn" for="S">S</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" class="size-selector" name="size[]" value="M" id="M" autocomplete="off">
                                        <label class="size-btn" for="M">M</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" class="size-selector" name="size[]" value="L" id="L" autocomplete="off">
                                        <label class="size-btn" for="L">L</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" class="size-selector" name="size[]" value="XL" id="XL" autocomplete="off">
                                        <label class="size-btn" for="XL">XL</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" class="size-selector" name="size[]" value="XXL" id="XXL" autocomplete="off">
                                        <label class="size-btn" for="XXL">XXL</label>
                                    </li>
                                    <li>
                                </ul>
                            </div>




                        </div>
                        <button type="submit" class="filter-btn">Tìm sản phẩm</button>
                    </form>

                </div>
                <div class="col-lg-9">
                    <div class="row pro-list">
                        <?php
                        include_once("private/controllers/timkiem_controller.php");
                        $timkiemController = new TimKiemController();
                        $timkiemController->TimKiem();
                        ?>
                    </div>
                </div>
            </div>



            <div class="direction-bar">
            <div class="col-12">
                
                <?php
                $timkiemController = new TimKiemController();
                $timkiemController->LoadThanhPhanTrang();
                ?>
                
            </div>

        </div>
        </div>
    </div>

    
        <?php
            include_once("private/controllers/timkiem_controller.php");
            $timkiemController = new TimKiemController();
            $timkiemController->LoadBottomBanner();
        ?>
    <footer>
        <?php
        include_once("public/templates/footer.php");
        ?>
    </footer>
    <script src="public/scripts/templates.js"></script>
    <script src="public/scripts/ketquatimkiem.js"></script>
</body>

</html>