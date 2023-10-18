<?php
require_once("private/models/taikhoan_model.php");
require_once("private/models/hoadon_model.php");
require_once("private/modules/config.php");

class QuanLyDonHangController{
    public function LoadPage(){
        $taikhoan = isset($_SESSION["taikhoan"]) ? $_SESSION["taikhoan"] : -1;
        if ($taikhoan == -1){
            header('Location: ?to=login');
            }else{
            $taikhoanmodel = new TaikhoanModel;
            $role = $taikhoanmodel->LoadPhanQuyen($_SESSION["taikhoan"]['tendangnhap']);
            if($role != 0){
                header("Location: index.php");
            }
            else{
                $action = isset($_POST["action"]) ? $_POST["action"] : -1;

                if ($action == -1) {
                $action = isset($_GET["action"]) ? $_GET["action"] : -1;
                }

                if($action == 'chitietdonhang'){
                    $idhoadon = $_GET['id'];
                    $this->LoadChiTietDonHang($idhoadon);
                    exit();
                }
                if($action == 'thongke'){
                    $this->ThongKe();
                   exit();
                }
                if($action == 'timkiem'){
                    if(isset($_GET['status'])){
                        $trangthai = $_GET['status'];
                        $this->LoadDonHangTheoTrangThai($trangthai);
                        exit();
                    }else {
                        $sdt= $_GET['phonenumber'];
                        $this->LoadDonHangTheoSDT($sdt);
                        exit();
                    }
                    
                }
                if($action == 'capnhattrangthai'){
                    $status = $_GET['status'];
                    $idhoadon = $_GET['id'];
                    $this->CapNhatTrangThai($idhoadon,$status);
                    header("Location: ?to=donhang");
                }
                if ($action == "qlybanner"){
                    header("Location: ?to=banner");
                }

                if ($action == "qlydonhang"){
                    header("Location: ?to=donhang");
                }

                if ($action == "dangxuat") {
                    unset($_SESSION["taikhoan"]);
                    header("Location: index.php");
                }
                
                }
            }$this->LoadQuanLyDonHang();
    }
    public function LoadQuanLyDonHang(){
        $hoaDonModel = new HoaDonModel;
        $hoadon = $hoaDonModel->LoadAll();        
        
        echo
        "
        <div class='container-fluid'>
        <div class='row mt-4'>";
        include('public/templates/dashboard.php');
        echo "
        <div class='col-lg-8 col-sm-12'><div class='ad-searchbar' id='search-bar'>
            <form class='d-flex justify-content-center'>
                <input type='hidden' name='to' value='donhang'>
                
                <input type='hidden' name='action' value='timkiem'>
                <input type='text' name='phonenumber' class='ad-search-box' placeholder='Tìm kiếm'>
                <button type='submit' class='search-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                        <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z' />
                    </svg>
                </button>
            </form>
        </div>
        <div class='row ad-header'>
            <h3  class='col-md-12 col-lg-5' id='ad-tit'>Quản lý đơn hàng</h3>
            <a href='?to=donhang&amp;action=thongke' class='ad-addbtn button'> Thống kê doanh số</a>
        </div>
        <div class='filter mb-3'>
            <form method='get'>
                <div class='form-floating '>
                <input type='hidden' name='to' value='donhang'>
                <input type='hidden' name='action' value='timkiem'>
                    <select class='form-select' id='floatingSelect' aria-label='Floating label select example' name='status'>";
                    $trangthai = array ('Đã hủy','Chờ xác nhận','Đã xác nhận','Đã đóng gói','Đang giao hàng','Đã hoàn thành');
                        for ($i = 0 ; $i<count($trangthai); $i++ ){
                            if( $hoadon[0]['trangthai'] == $trangthai[$i]){
                                echo "<option value='$trangthai[$i]' selected> $trangthai[$i]</option>";
                            }else
                                echo "<option value='$trangthai[$i]'> $trangthai[$i]</option>";
                        }
                    echo"
                    </select>
                    <label for='floatingSelect'>Trạng thái</label>
           
                </div>
            <button type='submit' class='filterbtn button'>Lọc</button>
            </form>
        </div>
        ";
        for($i = 0; $i < count($hoadon); $i++){
            echo"
            <div class='order-row mb-3'>
                <div class='order-status'>
                    <p>Ngày đặt hàng: ".$hoadon[$i]['ngaylap']."</p>
                    <p>".$hoadon[$i]['trangthai']."</p>
                </div>
                <div class='order-id'>
                    <strong>#Mã đơn hàng: ".$hoadon[$i]['id_hoadon']."</strong>
                </div>
                
                <div class='order-info row'>
                    <div class='order-recinfo'>
                        <p>Thông tin giao hàng</p>
                        <span>".$hoadon[$i]['hoten']."</span><br>
                        <span>".$hoadon[$i]['sodienthoai']."</span><br>
                        <span>".$hoadon[$i]['diachi']."</span>
                        
                    </div>
                    <div class='order-method'> 
                        <p>Hình thức thanh toán/vận chuyển</p>
                        <p>".$hoadon[$i]['hinhthucthanhtoan']."/".$hoadon[$i]['hinhthucvanchuyen']."</p>
                    </div>
                    <div class='order-value'> 
                        <p>Tổng đơn hàng</p>
                        <strong>".number_format($hoadon[$i]['tongtien'],0,',',',') ."₫</strong>
                    </div>
                    
                </div>
                <div class='order-detail'>
                        <a href='?to=donhang&action=chitietdonhang&id=".$hoadon[$i]['id_hoadon']."'> Xem chi tiết</a>
                    </div>
            </div>
            ";
        }
    }
    private function LoadChiTietDonHang($idhoadon)
    {
        $hoaDonModel = new HoaDonModel;
        $sanpham = $hoaDonModel->LoadChiTietHoaDon($idhoadon);
        $hoadon = $hoaDonModel->LoadThongTinHoaDon($idhoadon);

        echo
        "
        <div class='container-fluid'>
        <div class='row mt-4'>";
        include('public/templates/dashboard.php');
        echo"
        <div class='col-lg-8 col-sm-12'>
        <form method='get'>
                <input type='hidden' name='to' value='donhang'>
                <input type='hidden' name='id' value='$idhoadon'>
                <div class='order-row mb-3'>
                    <div class='order-status'>
                        <p>Ngày đặt hàng: ".$hoadon[0]['ngaylap']."</p>
                        <div class='form-floating mb-3'>
                        <select class='form-select' id='floatingSelect' aria-label='Floating label select example' name='status'>
                        ";
                        $trangthai = array ('Đã hủy','Chờ xác nhận','Đã xác nhận','Đã đóng gói','Đang giao hàng','Đã hoàn thành');
                        for ($i = 0 ; $i<count($trangthai); $i++ ){
                            if( $hoadon[0]['trangthai'] == $trangthai[$i]){
                                echo "<option value='$trangthai[$i]' selected> $trangthai[$i]</option>";
                            }else
                                echo "<option value='$trangthai[$i]'> $trangthai[$i]</option>";
                        }
                        echo "    
                            </select>
                            <label for='floatingSelect'>Trạng thái</label>
                        
                            </div>
                        </div>
                    <div class='order-id'>
                        <strong>#Mã đơn hàng: ".$hoadon[0]['id_hoadon']."</strong>
                    </div>
                    <div class='order-info row'>
                        <div class='order-recinfo  col-xl-6 col-lg-6 col-12'>
                            <p><strong>Thông tin giao hàng</strong></p>
                            <span>".$hoadon[0]['hoten']."</span><br>
                            <span>".$hoadon[0]['sodienthoai']."</span><br>
                            <span>".$hoadon[0]['diachi']."</span><br>
                            <span>Hình thức vận chuyển: ".$hoadon[0]['hinhthucvanchuyen']."</span><br>
                            <span>Hình thức thanh toán: ".$hoadon[0]['hinhthucthanhtoan']."</span><br>
                        </div>
                        <div class='order-products col-xl-6 col-lg-6 col-12'>
                        <p><strong>Thông tin đơn hàng</strong></p>
                        <table class='product-table'>
                            <thead>
                                <tr>
                                    <th><span class='visually-hidden'>Ảnh sản phẩm</span></th>
                                    <th><span class='visually-hidden'>Thông tin sản phẩm</span< /th>
                                    <th><span class='visually-hidden'>Số lượng</span< /th>
                                    <th><span class='visually-hidden'>Đơn giá</span< /th>
                                </tr>

                            </thead>
                            <tbody>";
                        foreach ($sanpham as $key => $value) {
                            echo
                            "
                            <tr class='product'>
                                <td class='product-image'>
                                    <div class='product-thumbnail'>
                                        <div class='thumbnail-wrapper'>
                                            <img class='thumbnail-img' src='".$value["anhchinh"]."'>
                                            <span class='thumbnail-quantity'>".$value["soluong"]."</span>
                                        </div>
                                    </div>
                            </td>
                            <th class='product-desc'>
                                <span class='product-name'>".$value["ten"]."</span>
                                <span class='product-info'>Size: ".$value["size"]."</span>
                            </th>
                            <td class='product-quantity visually-hidden'>".$value["soluong"]."</td>
                            <td class='product-price'>
                                    <span>".number_format($value["thanhtien"],0,".",",")."₫</span>
                                </td>
                        </tr>
                        ";}
                        echo "</tbody>
                        </table>
                        <div >
                            <p class='summary'>Phí vận chuyển: <span> ".number_format($hoadon[0]['phivanchuyen'],0,',',',') ."₫</span></p>
                            <p class='summary'>Tổng đơn hàng: <strong>".number_format($hoadon[0]['tongtien'],0,',',',') ."₫</strong></p>
                        </div>
                        </div>
                        <button type='submit' name='action' value='capnhattrangthai' class='button update-status-btn mt-2'>Cập nhật trạng thái </button>
                    </div>
                    
                    </form>
                </div> ";
    }
    private function CapNhatTrangThai($idhoadon,$status){
        $hoaDonModel = new HoaDonModel;
        $hoaDonModel->CapNhatTrangThai($idhoadon,$status);
    }
    private function LoadDonHangTheoTrangThai($trangthai){
        $hoaDonModel = new HoaDonModel;
        $hoadon = $hoaDonModel->LoadHoaDonTheoTrangThai($trangthai);
        
        echo
        "
        <div class='container-fluid'>
        <div class='row mt-4'>";
        include('public/templates/dashboard.php');
        echo "
        <div class='col-lg-8 col-sm-12'>
        <div class='ad-searchbar' id='search-bar'>
            <form class='d-flex justify-content-center'>
                <input type='hidden' name='to' value='donhang'>
                
                <input type='hidden' name='action' value='timkiem'>
                <input type='text' name='phonenumber' class='ad-search-box' placeholder='Tìm kiếm'>
                <button type='submit' class='search-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                        <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z' />
                    </svg>
                </button>
            </form>
        </div>
        <div class='row ad-header'>
            <h3  class='col-md-12 col-lg-5' id='ad-tit'>Quản lý sản phẩm</h3>
            <a href='?to=donhang&amp;action=thongke' class='ad-addbtn button'> Thống kê doanh số</a>
        </div>
        <div class='filter mb-3'>
        <form method='get'>
        <div class='form-floating '>
        <input type='hidden' name='to' value='donhang'>
        <input type='hidden' name='action' value='timkiem'>
            <select class='form-select' id='floatingSelect' aria-label='Floating label select example' name='status'>";
            $tt = array ('Đã hủy','Chờ xác nhận','Đã xác nhận','Đã đóng gói','Đang giao hàng','Đã hoàn thành');
                for ($i = 0 ; $i<count($tt); $i++ ){
                    if( $trangthai == $tt[$i]){
                        echo "<option value='$tt[$i]' selected> $tt[$i]</option>";
                    }else
                        echo "<option value='$tt[$i]'> $tt[$i]</option>";
                }
            echo"
            </select>
            <label for='floatingSelect'>Trạng thái</label>
   
        </div>
    <button type='submit' class='filterbtn button'>Lọc</button>
    </form>
        </div>
        ";
        for($i = 0; $i < count($hoadon); $i++){
            echo"
            <div class='order-row mb-3'>
                <div class='order-status'>
                    <p>Ngày đặt hàng: ".$hoadon[$i]['ngaylap']."</p>
                    <p>".$hoadon[$i]['trangthai']."</p>
                </div>
                <div class='order-id'>
                    <strong>#Mã đơn hàng: ".$hoadon[$i]['id_hoadon']."</strong>
                </div>
                
                <div class='order-info row'>
                    <div class='order-recinfo'>
                        <p>Thông tin giao hàng</p>
                        <span>".$hoadon[$i]['hoten']."</span><br>
                        <span>".$hoadon[$i]['sodienthoai']."</span><br>
                        <span>".$hoadon[$i]['diachi']."</span>
                        
                    </div>
                    <div class='order-method'> 
                        <p>Hình thức thanh toán/vận chuyển</p>
                        <p>".$hoadon[$i]['hinhthucthanhtoan']."/".$hoadon[$i]['hinhthucvanchuyen']."</p>
                    </div>
                    <div class='order-value'> 
                        <p>Tổng đơn hàng</p>
                        <strong>".number_format($hoadon[$i]['tongtien'],0,',',',') ."₫</strong>
                    </div>
                    
                </div>
                <div class='order-detail'>
                        <a href='?to=donhang&action=chitietdonhang&id=".$hoadon[$i]['id_hoadon']."'> Xem chi tiết</a>
                    </div>
            </div>
            ";
        }
    }
    private function LoadDonHangTheoSDT($sdt){
        $hoaDonModel = new HoaDonModel;
        $hoadon = $hoaDonModel->LoadHoaDonTheoSDT($sdt);
        echo
        "
        <div class='container-fluid'>
        <div class='row mt-4'>";
        include('public/templates/dashboard.php');
        echo "
        <div class='col-lg-8 col-sm-12'>
        <div class='ad-searchbar' id='search-bar'>
            <form class='d-flex justify-content-center'>
                <input type='hidden' name='to' value='donhang'>
                
                <input type='hidden' name='action' value='timkiem'>
                <input type='text' name='phonenumber' class='ad-search-box' placeholder='Tìm kiếm'>
                <button type='submit' class='search-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                        <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z' />
                    </svg>
                </button>
            </form>
        </div>
        <div class='row ad-header'>
            <h3  class='col-md-12 col-lg-5' id='ad-tit'>Quản lý sản phẩm</h3>
            <a href='?to=donhang&amp;action=thongke' class='ad-addbtn button'> Thống kê doanh số</a>
        </div>
        <div class='filter mb-3'>
        <form method='get'>
        <div class='form-floating '>
        <input type='hidden' name='to' value='donhang'>
        <input type='hidden' name='action' value='timkiem'>
            <select class='form-select' id='floatingSelect' aria-label='Floating label select example' name='status'>";
            $tt = array ('Đã hủy','Chờ xác nhận','Đã xác nhận','Đã đóng gói','Đang giao hàng','Đã hoàn thành');
                for ($i = 0 ; $i<count($tt); $i++ ){
                    if( $status == $tt[$i]){
                        echo "<option value='$tt[$i]' selected> $tt[$i]</option>";
                    }else
                        echo "<option value='$tt[$i]'> $tt[$i]</option>";
                }
            echo"
            </select>
            <label for='floatingSelect'>Trạng thái</label>
   
        </div>
    <button type='submit' class='filterbtn button'>Lọc</button>
    </form>
        </div>
        <p>Kết quả tìm kiếm cho đơn hàng có số điện thoại: '".$sdt."'</p>
        ";
        for($i = 0; $i < count($hoadon); $i++){
            echo"
            <div class='order-row mb-3'>
                <div class='order-status'>
                    <p>Ngày đặt hàng: ".$hoadon[$i]['ngaylap']."</p>
                    <p>".$hoadon[$i]['trangthai']."</p>
                </div>
                <div class='order-id'>
                    <strong>#Mã đơn hàng: ".$hoadon[$i]['id_hoadon']."</strong>
                </div>
                
                <div class='order-info row'>
                    <div class='order-recinfo'>
                        <p>Thông tin giao hàng</p>
                        <span>".$hoadon[$i]['hoten']."</span><br>
                        <span>".$hoadon[$i]['sodienthoai']."</span><br>
                        <span>".$hoadon[$i]['diachi']."</span>
                        
                    </div>
                    <div class='order-method'> 
                        <p>Hình thức thanh toán/vận chuyển</p>
                        <p>".$hoadon[$i]['hinhthucthanhtoan']."/".$hoadon[$i]['hinhthucvanchuyen']."</p>
                    </div>
                    <div class='order-value'> 
                        <p>Tổng đơn hàng</p>
                        <strong>".number_format($hoadon[$i]['tongtien'],0,',',',') ."₫</strong>
                    </div>
                    
                </div>
                <div class='order-detail'>
                        <a href='?to=donhang&action=chitietdonhang&id=".$hoadon[$i]['id_hoadon']."'> Xem chi tiết</a>
                    </div>
            </div>
            ";
        }
    }
    private function ThongKe(){
        $hoaDonModel = new HoaDonModel;
        $hoadonsum = $hoaDonModel->LoadAll();

        $tt = array ('Chờ xác nhận','Đã xác nhận','Đã đóng gói','Đang giao hàng','Đã hoàn thành','Đã hủy');
        $donhang = array();
        for($i = 0; $i<count($tt); $i++){
            $donhang[$i] = count($hoaDonModel->LoadHoaDonTheoTrangThai($tt[$i]));
        }
        

        $tongdaban = 0 ;
        $tongdangcho = 0;
        for($i = 0; $i < count($hoadonsum); $i++){
            if($hoadonsum[$i]['trangthai'] == 'Đã hoàn thành' || $hoadonsum[$i]['hinhthucthanhtoan'] == 'Chuyển khoản'){
                $tongdaban = $tongdaban + $hoadonsum[$i]['tongtien'] -$hoadonsum[$i]['phivanchuyen'];
            }else {
                $tongdangcho = $tongdangcho + $hoadonsum[$i]['tongtien'] -$hoadonsum[$i]['phivanchuyen'];
            }
        }
        $tongthunhap = $tongdaban + $tongdangcho;
        echo
        "
        <div class='container-fluid'>
        <div class='row mt-4'>";
        include('public/templates/dashboard.php');
        echo"
        <div class='col-lg-8 col-sm-12 mt-5'>
        <div class='row'>
        <div class='ad-header'>
            <h3  class='col-md-12 col-lg-5' id='ad-tit'>Thống kê doanh số</h3>
            <a style='text-decoration: underline;' href='?to=donhang'>🡐 Quay lại</a>
        </div>
        <div class='col-6 col-lg-6 statistics-tit'>
                <p>Tổng thu nhập dự tính: </p>
                <p>Tổng giá trị đơn hàng đã bán: </p>
                <p>Tổng giá trị đơn hàng đang chờ: </p>
                <br>
                <p>Đơn hàng chờ xác nhận: </p>
                <p>Đơn hàng đã xác nhận: </p>
                <p>Đơn hàng đã đóng gói: </p>
                <p>Đơn hàng đang giao hàng: </p>
                <p>Đơn hàng đang đã hoàn thành: </p>
                <p>Đơn hàng đang đã hủy: </p>
            </div>
            <div class='col-6 col-lg-6 statistics'>
            <p ><strong>".number_format($tongthunhap,0,',',',') ."₫</strong></p>
            <p style='color:#008800'><strong>".number_format($tongdaban,0,',',',') ."₫</strong></p>
            <p style='color:#CC0000'><strong>".number_format($tongdangcho,0,',',',') ."₫</strong></p>
            <br>
            <p style='color:#CC0000'><strong>".$donhang[0]."</strong></p>
            <p style='color:#000'><strong>".$donhang[1]."</strong></p>
            <p style='color:#000'><strong>".$donhang[2]."</strong></p>
            <p style='color:#000'><strong>".$donhang[3]."</strong></p>
            <p style='color:#008800'><strong>".$donhang[4]."</strong></p>
            <p style='color:#CC0000'><strong>".$donhang[5]."</strong></p>
            </div>
            </div>";
            
    }
}
?>