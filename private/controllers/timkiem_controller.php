<?php
include_once("private/models/sanpham_model.php");
include_once("private/models/banner_model.php");
include_once("private/modules/config.php");
class TimKiemController{
    public function TimKiem()
    {
        // Kiểm tra đế từ trang nào
        if (isset($_GET["from"])) {
            $from = $_GET["from"];
            switch ($from) {
                    // Đến từ bản thân
                case 'self':
                    $this->TimKiemTuFilter();
                    break;
                    // đến từ trang khác
                case 'another':
                    $this->TimKiemTuTrangKhac();
                    break;
                case 'searchbar':
                    $this->TimKiemTuSearchBar();
                default:
                    // header("Location: ./?to=home");
                    break;
            }
        } else {
            // header("Location: ./?to=home");
        }
    }
    private function TimKiemTuFilter()
    {
        // Lấy tham số tìm kiếm: thương hiệu, giá, size
        $danhmuc = isset($_GET["danhmuc"]) ? $_GET["danhmuc"] : -1;
        $gia = isset($_GET["gia"]) ? $_GET["gia"] : -1;
        $size = isset($_GET["size"]) ? $_GET["size"] : -1;

        //Truy vấn danh sách giày
        $sanphams = array();
        $sanPhamModel = new SanPhamModel();
        $sanphams = $sanPhamModel->LoadSanPhamTheoFilter($danhmuc,  $gia, $size);

        //Kiểm tra có phân trang chưa
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $this->LoadSanPham($sanphams, $page);

        // Lưu danh sách giày vào session
        $_SESSION['sanphams'] = $sanphams;
    }
    private function TimKiemTuTrangKhac()
    {
        if (isset($_GET["name"])) {
            $name = $_GET["name"];
            switch ($name) {
                case 'loai':
                    $this->LoadLoaiSP();
                    break;
                case 'xemthem':
                    $this->LoadXemThem();
                    break;
                default:
                    header("Location: ./?to=home");
                    break;
            }
        } else {
            header("Location: ./?to=home");
        }
    }
    private function TimKiemTuSearchBar()
    {
        $key = $_GET["key"];

        // Truy vấn danh sách sản phẩm theo loại
        $sanPhamModel = new SanPhamModel();
        $sanphams = $sanPhamModel->LoadSanPhamTheoTenHoacLoai($key);

        //Kiểm tra có phân trang chưa
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $this->LoadSanPham($sanphams, $page);

        // Lưu danh sách giày vào session
        $_SESSION['sanphams'] = $sanphams;

    }
    private function LoadLoaiSP()
    {

        if (isset($_GET["value"])) {

            // Truy vấn danh sách sản phẩm theo loại
            $sanPhamModel = new SanPhamModel();
            $sanphams = $sanPhamModel->LoadSanPhamTheoDanhMuc($_GET["value"]);


            //Kiểm tra có phân trang chưa
            $page = isset($_GET["page"]) ? $_GET["page"] : 1;
            $this->LoadSanPham($sanphams, $page);

            // Lưu danh sách giày vào session
            $_SESSION['sanphams'] = $sanphams;
        } else {
            
            header("Location: ./?to=home");
        }
        

    }
    private function LoadXemThem()
    {
        if (isset($_GET["value"])) {
            switch ($_GET["value"]) {
                case 'moi':
                    $this->LoadSPMoi();
                    break;
                case 'hotsale':
                    $this->LoadSPGiamGia();
                    break;

                default:
                    header("Location: ./?to=home");

                    break;
            }
        } else {
            header("Location: ./?to=home");
        }
    }
    private function LoadSPMoi()
    {
        //Truy vấn danh sách sản phẩm newarrival
        $sanPhamModel = new SanPhamModel();
        $sanphams = $sanPhamModel->LoadNewArrivals("".getdate()['year']." - ".getdate()['mon']."");

        //Kiểm tra có phân trang chưa
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $this->LoadSanPham($sanphams, $page);

        // Lưu danh sách giày vào session
        $_SESSION['sanphams'] = $sanphams;
    }
    private function LoadSPGiamGia()
    {

        // Truy vấn danh sách sản phẩm HoteSale
        $sanPhamModel = new SanPhamModel();
        $sanphams = $sanPhamModel->LoadHotSale();

        //Kiểm tra có phân trang chưa
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $this->LoadSanPham($sanphams, $page);

        // Lưu danh sách giày vào session
        $_SESSION['sanphams'] = $sanphams;
    }
    
    public function LoadThanhPhanTrang()
    {

        if (isset($_SESSION["sanphams"])) {

            $sanphams = $_SESSION["sanphams"];

            // Số lượng sản phẩm hiện có            
            $soluongsanphamhienco = count($sanphams);

            // Số trang hiển thị
            $total = ceil($soluongsanphamhienco / SO_SP_TREN_TRANG);

            // Kiểm tra đến từ trang nào
            if ($_GET["from"] == "self") {
                
                // Lấy url hiện tại
                $danhmuc = isset($_GET["danhmuc"]) ? $_GET["danhmuc"] : -1;
                $gia = isset($_GET["gia"]) ? $_GET["gia"] : -1;
                $size = isset($_GET["size"]) ? $_GET["size"] : -1;

                $href = "./?to=search&from=self";
                if ($danhmuc != -1) {
                    for (
                        $i = 0;
                        $i < count($danhmuc);
                        $i++
                    ) {
                        $href .= "&danhmuc%5B%5D=" . $danhmuc[$i] . "";
                    }
                }
                if ($gia != -1) {
                    for ($i = 0; $i < count($gia); $i++) {
                        $href .= "&gia%5B%5D=" . $gia[$i] . "";
                    }
                }
                if ($size != -1) {
                    for ($i = 0; $i < count($size); $i++) {
                        $href .= "&size%5B%5D=" . $size[$i] . "";
                    }
                }

                // Hiển thị thanh phân trang
                for ($i = 1; $i <= $total; $i++) {

                    echo
                    "
                      <a class='to-num' href='$href&page=$i' >$i</a>
                    ";
                }
            }

            // Kiểm tra tham số phân trang
            $page = isset($_GET["page"]) ? $_GET["page"] : 1 ;
            if ($_GET["from"] == "another")
            {

                // Lấy url
                $name = $_GET["name"];
                $value = $_GET["value"];

                // Hiển thị thanh phân trang
                for ($i = 1; $i <= $total; $i++) {

                    if ($i == $page) {
                        
                        echo
                        "
                            <span class='to-num current'>" . $i . "</span>
                        ";
                    } else {
                        echo
                        "
                            <a class='to-num' href='./?to=search&from=another&name=" . $name . "&value=" . $value . "&page=" . $i . "'>" . $i . "</a>
                        ";
                    }

                    
                }
            }
            if ($_GET["from"] == "searchbar") {
                // Lấy url
                $key= $_GET["key"];

                // Hiển thị thanh phân trang
                for ($i = 1; $i <= $total; $i++) {

                    if ($i == $page) {
                      
                        echo
                        "
                        <span class='to-num current'>" . $i . "</span>
                        ";
                    }
                    else {
                        echo
                        "
                            <a class='to-num' href='./?to=search&from=searchbar&key=".$key."&page=" . $i . "'>" . $i . "</a>
                        ";
                    }

                   
                }
            }
        }
    }
    private function LoadSanPham($sanpham, $page)
    {
        $from = ($page - 1) * SO_SP_TREN_TRANG;
        $dem = 1;
        for ($i = $from; $i < count($sanpham) && $dem <= SO_SP_TREN_TRANG; $i++) {

            // Trường hợp giày có thông tin giảm giá
            if (isset($sanpham[$i]["giagiam"])) {
                $phantramgiam = round(100-($sanpham[$i]['giagiam']/$sanpham[$i]['gia'])*100);
                echo ("
                        <div class='col-lg-3 col-md-6 col-6 products'>
                            <div class='pro-img'>
                                <div class='pro-sale'><span>-".$phantramgiam."%</span></div>
                                <a href='./?to=detail&id=".$sanpham[$i]["id_sanpham"]."'>
                                    <img class='pro-img pro-img-1' src='".$sanpham[$i]["anhphu1"]."'>
                                    <img class='pro-img' src='".$sanpham[$i]["anhchinh"]."'>

                                </a>
                                <div class='pro-btn d-flex'>
                                    <a href='./?to=detail&id=".$sanpham[$i]["id_sanpham"]."' class='hidden-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                                    <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                                    <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                  </svg></a>
                                </div>
                            </div>
                            <div class='pro-detail'>
                                <h3 class='pro-name'><a href='./?to=detail&id=".$sanpham[$i]["id_sanpham"]."'>".$sanpham[$i]["ten"]."</a></h3>
                                <div class='pro-price'>
                                    <p class='pro-price sale'>".number_format($sanpham[$i]['giagiam'], 0, ',', ',')."đ 
                                        <span class='pro-price-retail'><del>".number_format($sanpham[$i]["gia"], 0, ',', ',')."₫</del></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                     ");
            }

            // Trường hợp giày không có thông tin giảm giá
            else{               
                echo ("
                        <div class='col-lg-3 col-md-6 col-6 products'>
                            <div class='pro-img'>
                    
                                <a href='./?to=detail&id=".$sanpham[$i]["id_sanpham"]."'>
                                    <img class='pro-img pro-img-1' src='".$sanpham[$i]["anhphu1"]."'>
                                    <img class='pro-img' src='".$sanpham[$i]["anhchinh"]."'>

                                </a>
                                <div class='pro-btn d-flex'>
                                    <a href='./?to=detail&id=".$sanpham[$i]["id_sanpham"]."' class='hidden-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                                    <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                                    <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                  </svg></a>
                                </div>
                            </div>
                            <div class='pro-detail'>
                                <h3 class='pro-name'><a href='./?to=detail&id=".$sanpham[$i]["id_sanpham"]."'>".$sanpham[$i]["ten"]."</a></h3>
                                <div class='pro-price'>
                                    <p class='pro-price'>
                                        <span>".number_format($sanpham[$i]["gia"],0, ',', ',')."₫</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                     ");
            }

            $dem++;
        }
    }
    public function LoadBottomBanner()
    {
        $bannerModel = new  BannerModel();
        $banners = $bannerModel->LoadBanners("tim kiem", "bot");
        echo"
            <div id='carouselExampleSlidesOnly' class='carousel slide' data-bs-ride='carousel'>
            <div class='carousel-inner'>";

        for ($i = 0; $i < count($banners); $i++) {
            if ($i == 0) {
                echo
                "
                <div class='carousel-item active'>
                    <a href='?to=search&from=another&name=loai&value=".$banners[$i]["value"]."'><img src='" . $banners[$i]["diachianh"] . "' class='d-block w-100' alt=''></a>
                </div>
                ";
            } else {
                echo
                "
                    <div class='carousel-item'>
                    <a href='?to=search&from=another&name=loai&value=".$banners[$i]["value"]."'><img src='" . $banners[$i]["diachianh"] . "' class='d-block w-100' alt=''></a>
                    </div>
                    ";
            }
        }
        echo" </div>
        </div>";
    }

}

?>