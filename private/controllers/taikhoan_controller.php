<?php
require_once("private/models/taikhoan_model.php");
require_once("private/models/hoadon_model.php");
class TaiKhoanController{
    public function LoadPage(){
        
        $taikhoan = isset($_SESSION["taikhoan"]) ? $_SESSION["taikhoan"] : -1;
        if ($taikhoan == -1) {
            header("Location: ./?to=login");
        }
        else {
            $action = isset($_POST["action"]) ? $_POST["action"] : -1;
            if ($action == -1) {
                $action = isset($_GET["action"]) ? $_GET["action"] : -1;
            }

            if ($action == "capnhat") {
                $result = $this->CapNhatThongTinKhachHang($taikhoan);
                if ($result == false) {
                    $this->CapNhatThongTinKhachHangThatBai($taikhoan);
                }
                else {
                    $this->CapNhatThongTinKhachHangThanhCong($taikhoan);
                }
                exit();
            }

            if ($action == 'changepassword'){
                $this->LoadFormDoiMatKhau();
                return;
            }

            if ($action == "thaydoimatkhau"){
                $result = $this->ThayDoiMatKhau($taikhoan);
                if ($result == false) {
                    $this->ThayDoiMatKhauThatBai($taikhoan);
                }
                else {
                    $this->ThayDoiMatKhauThanhCong($taikhoan);
                }
                exit();
            }
            if ($action == "theodoidonhang") {
                $this->LoadTheoDoiDonHang($taikhoan);
                exit();
            }

            if($action == 'chitietdonhang'){
                $idhoadon = $_GET['id'];
                $this->LoadChiTietDonHang($idhoadon);
                exit();
            }

            if ($action == "dangxuat") {
                if (isset($_SESSION["taikhoan"])) {
                    unset($_SESSION["taikhoan"]);
                    header("Location: index.php");
                }
            }
            $this->LoadTaiKhoanInfo($taikhoan);
            
        }

    }

    private function LoadTaiKhoanInfo($taikhoan){
        
        $taiKhoanModel = new TaikhoanModel();
        $khachhanginfo = $taiKhoanModel->LoadThongTinTaiKhoan($taikhoan['id_taikhoan']);
        echo "
        <style>
        #hai,#ba {
            background-color: #FFF;
            color: #000;
            border-bottom: 1px solid;
        }
        </style>";
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";
        include_once("public/templates/accountmenu.php");
        echo
        "
            <div class='col-lg-9 col-md-12' id='form1'>
                <div class='heading' style='padding-bottom:0'>
                    <h3 class='text-uppercase'>Thông tin tài khoản</h3>
                </div>
                <form class='dky-form' method='post' action='./'>
                    <input type='hidden' name='to' value='account'>
                    <input type='hidden' name='idkhachhang' value='".$khachhanginfo["id_khachhang"]."'>
                    <div class='mb-2'>
                        <label for='username' class='form-label'>Tài khoản</label>
                        <input type='text' id='username' value='".$taikhoan["tendangnhap"]."' class='form-control' placeholder='Tên đang nhập' disabled>
                    </div>
                    <div class='row'>
                        <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                            <!--Họ-->
                            <div class='mb-2'>
                                <label for='ho' class='form-label'>Họ</label>
                                <input type='text' name='ho' value='".$khachhanginfo["ho"]."' class='form-control' id='ho'>
                            </div>
                        </div>
                        <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                            <!--Tên-->
                            <div class='mb-2'>
                                <label for='ten' class='form-label'>Tên</label>
                                <input type='text' name='ten' value='".$khachhanginfo["ten"]."' class='form-control' id='ten'>
                            </div>
                        </div>
                    </div>
                    <div class='mb-2'>
                        <label for='address' class='form-label'>Địa chỉ</label>
                        <input type='text' name='diachi' value='".$khachhanginfo["diachi"]."' class='form-control' id='address'>
                    </div>
                    <div class='row'>
                        <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                            <div class='mb-2'>
                                <label for='number' class='form-label'>Số điện thoại</label>
                                <input type='number' name='sdt' value='".$khachhanginfo["sdt"]."' class='form-control' id='phone'>
                            </div>
                        </div>
                        <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                            <div class='mb-2'>
                                <label for='email' class='form-label'>Email</label>
                                <input type='email' name='email' value='".$khachhanginfo["email"]."' class='form-control' id='email'>
                            </div>
                        </div>
                    </div>
                    <button type='submit' name='action' value='capnhat' class='mt-3 update-btn button'>Cập nhật thông tin</button>

                </form>
            </div>
           
        </div>
     </div>
        </div>
        ";
        
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";
        echo
        
        "
        <script src='public/scripts/templates.js'></script>
        <script src='public/scripts/account.js'></script>
        ";
    }

    private function CapNhatThongTinKhachHang()
    {
        $ho = $_POST["ho"];
        $ten = $_POST["ten"];
        $diachi = $_POST["diachi"];
        $sdt = $_POST["sdt"];
        $email = $_POST["email"];
        $idkhachhang = $_POST["idkhachhang"];

        $taiKhoanModel = new TaiKhoanModel();
        $result = $taiKhoanModel->CapNhatThonTinKhachHang($idkhachhang, $ho, $ten, $sdt, $diachi, $email);
        return $result;
    }
    private function CapNhatThongTinKhachHangThanhCong($taikhoan)
    {
        $taiKhoanModel = new TaiKhoanModel();
        $khachhanginfo = $taiKhoanModel->LoadThongTinTaiKhoan($taikhoan["id_taikhoan"]);
        echo "
        <style>
        #hai,#ba {
            background-color: #FFF;
            color: #000;
            border-bottom: 1px solid;
        }
        </style>";
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";
        include_once("public/templates/accountmenu.php");
        echo
        "
                <!--form1-->
                    <div class='col-lg-9 col-md-12' id='form1'>
                    <div class='alert alert-success' role='alert'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-check-circle-fill' viewBox='0 0 16 16'>
                        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
                    </svg><span>    Cập nhật thông tin thành công!</span>
                  </div>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Thông tin tài khoản</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <input type='hidden' name='idkhachhang' value='".$khachhanginfo["id_khachhang"]."'>
                        <div class='mb-2'>
                            <label for='username' class='form-label'>Tài khoản</label>
                            <input type='text' id='username' value='".$taikhoan["tendangnhap"]."' class='form-control' placeholder='Tên đang nhập' disabled>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Họ-->
                                <div class='mb-2'>
                                    <label for='ho' class='form-label'>Họ</label>
                                    <input type='text' name='ho' value='".$khachhanginfo["ho"]."' class='form-control' id='ho'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Tên-->
                                <div class='mb-2'>
                                    <label for='ten' class='form-label'>Tên</label>
                                    <input type='text' name='ten' value='".$khachhanginfo["ten"]."' class='form-control' id='ten'>
                                </div>
                            </div>
                        </div>
                        <div class='mb-2'>
                            <label for='address' class='form-label'>Địa chỉ</label>
                            <input type='text' name='diachi' value='".$khachhanginfo["diachi"]."' class='form-control' id='address'>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='number' class='form-label'>Số điện thoại</label>
                                    <input type='number' name='sdt' value='".$khachhanginfo["sdt"]."' class='form-control' id='phone'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='email' class='form-label'>Email</label>
                                    <input type='email' name='email' value='".$khachhanginfo["email"]."' class='form-control' id='email'>
                                </div>
                            </div>
                        </div>
                        <button type='submit' name='action' value='capnhat' class='mt-3 update-btn button'>Cập nhật thông tin</button>

                    </form>
                </div>
            </div>
        </div>
        ";
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";
        echo
        
        "
        <script src='public/scripts/templates.js'></script>
        <script src='public/scripts/account.js'></script>
        ";
    }
    private function CapNhatThongTinKhachHangThatBai($taikhoan){
        $taiKhoanModel = new TaiKhoanModel();
        $khachhanginfor = $taiKhoanModel->LoadThongTinTaiKhoan($taikhoan["id_taikhoan"]);
        echo "
        <style>
        #hai,#ba {
            background-color: #FFF;
            color: #000;
            border-bottom: 1px solid;
        }
        </style>";
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";
        include_once("public/templates/accountmenu.php");
        echo
        "
                <!--form1-->
                <div class='col-lg-9 col-md-12' id='form1'>
                    <div class='alert alert-danger' role='alert'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-exclamation-circle-fill' viewBox='0 0 16 16'>
                    <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z'/>
                    </svg><span> Cập nhật thông tin thất bại: Vui lòng kiểm tra lại thông tin!</span>
                    </div>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Thông tin tài khoản</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <input type='hidden' name='idkhachhang' value='".$khachhanginfor["id_khachhang"]."'>
                        <div class='mb-2'>
                            <label for='username' class='form-label'>Tài khoản</label>
                            <input type='text' id='username' value='".$taikhoan["tendangnhap"]."' class='form-control' placeholder='Tên đang nhập' disabled>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Họ-->
                                <div class='mb-2'>
                                    <label for='ho' class='form-label'>Họ</label>
                                    <input type='text' name='ho' value='".$khachhanginfor["ho"]."' class='form-control' id='ho'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <!--Tên-->
                                <div class='mb-2'>
                                    <label for='ten' class='form-label'>Tên</label>
                                    <input type='text' name='ten' value='".$khachhanginfor["ten"]."' class='form-control' id='ten'>
                                </div>
                            </div>
                        </div>
                        <div class='mb-2'>
                            <label for='address' class='form-label'>Địa chỉ</label>
                            <input type='text' name='diachi' value='".$khachhanginfor["diachi"]."' class='form-control' id='address'>
                        </div>
                        <div class='row'>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='number' class='form-label'>Số điện thoại</label>
                                    <input type='number' name='sdt' value='".$khachhanginfor["sdt"]."' class='form-control' id='phone'>
                                </div>
                            </div>
                            <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                                <div class='mb-2'>
                                    <label for='email' class='form-label'>Email</label>
                                    <input type='email' name='email' value='".$khachhanginfor["email"]."' class='form-control' id='email'>
                                </div>
                            </div>
                        </div>
                        <span><strong>×</strong> Cập nhật thông tin thất bại: tài khoản hoặc mật khẩu không đúng</span>
                        <button type='submit' name='action' value='capnhat' class='mt-3 update-btn button'>Cập nhật thông tin</button>

                    </form>
                </div>
            </div>
        </div>
        ";
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";
        echo
        
        "
        <script src='public/scripts/templates.js'></script>
        <script src='public/scripts/account.js'></script>
        ";
    }
    private function LoadFormDoiMatKhau(){
        echo "
        <style>
        #mot,#ba {
            background-color: #FFF;
            color: #000;
            border-bottom: 1px solid;
        }
        </style>";
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";
        include_once("public/templates/accountmenu.php");
        echo
        "
                <div class='col-lg-9 col-md-12' id='form1'>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Đổi mật khẩu</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <div class='row justify-content-center'>
                            <div class='col-4'>
                                <label for='oldpwd' class='col-form-label'>Nhập mật khẩu cũ </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='oldpwd' name='matkhaucu' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd' class='col-form-label'>Nhập mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='newpwd' name='matkhaumoi' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd2' class='col-form-label'>Nhập lại mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' name='nhaplaimatkhaumoi' id='newpwd2' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>


                        <div class='col-7'>
                        <button type='submit' name='action' value='thaydoimatkhau' class='mt-4 update-btn button'>Đổi mật khẩu</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        ";
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";
        echo
        
        "
        <script src='public/scripts/templates.js'></script>
        <script src='public/scripts/account.js'></script>
        ";
    }
    private function ThayDoiMatKhau($taikhoan){
        $tendangnhap = $taikhoan["tendangnhap"];
        $matkhaucu = $_POST["matkhaucu"];
        $matkhaumoi = $_POST["matkhaumoi"];
        $nhaplaimatkhaumoi = $_POST["nhaplaimatkhaumoi"];

        $taiKhoanModel = new TaiKhoanModel();
        $result = $taiKhoanModel->ThayDoiMatKhau($tendangnhap, $matkhaucu, $matkhaumoi, $nhaplaimatkhaumoi);
        return $result;
    }
    private function ThayDoiMatKhauThatBai($taikhoan){
            
        $taiKhoanModel = new TaiKhoanModel();
        $khachhanginfo = $taiKhoanModel->LoadThongTinTaiKhoan($taikhoan["id_taikhoan"]);
        echo "
        <style>
        #mot,#ba {
            background-color: #FFF;
            color: #000;
            border-bottom: 1px solid;
        }
        </style>";
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";
        include_once("public/templates/accountmenu.php");
        echo
        "
                <!--form2-->
                <div class='col-lg-9 col-md-12' id='form1'>
                    <div class='alert alert-danger' role='alert'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-exclamation-circle-fill' viewBox='0 0 16 16'>
                    <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z'/>
                    </svg><span> Thay đổi mật khẩu thất bại: Vui lòng kiểm tra và nhập lại thông tin!</span>
                    </div>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Đổi mật khẩu</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <div class='row justify-content-center'>
                            <div class='col-4'>
                                <label for='oldpwd' class='col-form-label'>Nhập mật khẩu cũ </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='oldpwd' name='matkhaucu' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd' class='col-form-label'>Nhập mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='newpwd' name='matkhaumoi' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd2' class='col-form-label'>Nhập lại mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' name='nhaplaimatkhaumoi' id='newpwd2' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>


                        <div class='col-7'>
                        <button type='submit' name='action' value='thaydoimatkhau' class='mt-4 update-btn button'>Đổi mật khẩu</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        ";
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";
        echo
        
        "
        <script src='public/scripts/templates.js'></script>
        <script src='public/scripts/account.js'></script>
        ";

    }
    private function ThayDoiMatKhauThanhCong($taikhoan){
        $taiKhoanModel = new TaiKhoanModel();
        $khachhanginfo = $taiKhoanModel->LoadThongTinTaiKhoan($taikhoan["id_taikhoan"]);
        echo "
        <style>
        #mot,#ba {
            background-color: #FFF;
            color: #000;
            border-bottom: 1px solid;
        }
        </style>";
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";
        include_once("public/templates/accountmenu.php");
        echo
        "
                <!--form2-->
                <div class='col-lg-9 col-md-12' id='form1'>
                    <div class='alert alert-success' role='alert'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-check-circle-fill' viewBox='0 0 16 16'>
                        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
                        </svg><span>    Thay đổi mật khẩu thành công!</span>
                    </div>
                    <div class='heading' style='padding-bottom:0'>
                        <h3 class='text-uppercase'>Đổi mật khẩu</h3>
                    </div>
                    <form class='dky-form' method='post' action='./'>
                        <input type='hidden' name='to' value='account'>
                        <div class='row justify-content-center'>
                            <div class='col-4'>
                                <label for='oldpwd' class='col-form-label'>Nhập mật khẩu cũ </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='oldpwd' name='matkhaucu' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd' class='col-form-label'>Nhập mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' id='newpwd' name='matkhaumoi' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>
                        <div class='row justify-content-center mt-3'>
                            <div class='col-4'>
                                <label for='newpwd2' class='col-form-label'>Nhập lại mật khẩu mới </label>
                            </div>
                            <div class='col-auto'>
                                <input type='password' name='nhaplaimatkhaumoi' id='newpwd2' class='form-control' aria-describedby='passwordHelpInline'>
                            </div>
                        </div>


                        <div class='col-7'>
                        <button type='submit' name='action' value='thaydoimatkhau' class='mt-4 update-btn button'>Đổi mật khẩu</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        ";
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";
        echo
        
        "
        <script src='public/scripts/templates.js'></script>
        <script src='public/scripts/account.js'></script>
        ";
    }
    private function LoadTheoDoiDonHang($taikhoan){
        
        $hoaDonModel = new HoaDonModel;
        $hoadon = $hoaDonModel->LoadHoaDonCuaTaiKhoan($taikhoan["id_taikhoan"]);
        echo "
        <style>
        #hai,#mot {
            background-color: #FFF;
            color: #000;
            border-bottom: 1px solid;
        }
        </style>
        ";
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";
        include_once("public/templates/accountmenu.php");
        echo
        "<div class='col-lg-9 col-md-12'>
            <div class='heading' style='padding-bottom:0'>
                <h3 class='text-uppercase'>Theo dõi đơn hàng</h3>
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
                            <a href='?to=account&action=chitietdonhang&id=".$hoadon[$i]['id_hoadon']."'> Xem chi tiết</a>
                        </div>
                </div>
                ";
            }
                

              echo"  
                </div>
                </div>
        </div>
        ";
        
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";
        echo
        
        "
        <script src='public/scripts/templates.js'></script>
        <script src='public/scripts/account.js'></script>
        ";
    }
    private function LoadChiTietDonHang($idhoadon){
        $hoaDonModel = new HoaDonModel;
        $sanpham = $hoaDonModel->LoadChiTietHoaDon($idhoadon);
        $hoadon = $hoaDonModel->LoadThongTinHoaDon($idhoadon);
        echo "
        <style>
        #hai,#mot {
            background-color: #FFF;
            color: #000;
            border-bottom: 1px solid;
        }
        </style>
        ";
        echo"<header>";
        include_once("public/templates/header.php");
        echo"</header>";
        include_once("public/templates/accountmenu.php");
        echo
        "<div class='col-lg-9 col-md-12'>
            <div class='heading' style='padding-bottom:0'>
                <h3 class='text-uppercase'>Chi Tiết đơn hàng</h3>
            </div>
            
            ";
                echo"
                <div class='order-row mb-3'>
                    <div class='order-status'>
                        <p>Ngày đặt hàng: ".$hoadon[0]['ngaylap']."</p>
                        <p>".$hoadon[0]['trangthai']."</p>
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
                        
                    </div>
                    
                    
                </div> 
                <div class='order-detail'>
                            <a href='?to=account&action=theodoidonhang'>🡐 Quay lại theo dõi đơn hàng</a>
                        </div>
                </div>
                </div>
        </div>
        ";
        
        echo"<footer>";
        include_once("public/templates/footer.php");
        echo"</footer>";
        echo
        
        "
        <script src='public/scripts/templates.js'></script>
        <script src='public/scripts/account.js'></script>
        ";
    }
}
