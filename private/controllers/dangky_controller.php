<?php
require_once("private/models/taikhoan_model.php");
class DangKyController
{
    public function LoadPage()
    {
        
        $action = isset($_GET["action"]) ? $_GET["action"] : -1 ; 
        if ($action == "dangky") {
            
            $result = $this->DangKy();
            if ($result == true) {
                header("Location: ./?to=login");
            }
            else {
                $this->LoadKetQuaDangKy();
            }
        }
        else {
            
            $this->LoadFormDangKy();
        }
    }
    private function DangKy()
    {
        // Lấy thông tin tài khoản và mật khẩu 
        $tendangnhap = $_GET["tendangnhap"];
        $matkhau = $_GET["matkhau"];
        $nhaplaimatkhau = $_GET["nhaplaimatkhau"];

        $taiKhoanModel = new TaiKhoanModel();
        $idtaikhoan = $taiKhoanModel->DangKy($tendangnhap, $matkhau, $nhaplaimatkhau);
        if ($idtaikhoan == -1) {
            return false;
        }

        // Lấy thông tin khách hàng
        $ten = $_GET["ten"];
        $ho = $_GET["ho"];
        $sodienthoai = $_GET["sodienthoai"];
        $email = $_GET["email"];

        $idkhachhang = $taiKhoanModel->ThemThongTinKhachHang($ho, $ten, $sodienthoai, $email);
        
        if ($idkhachhang == -1) {
            return false;
        }

        // Link tài khoản và thông tin khách hàng
        $result = $taiKhoanModel->LinkTaiKhoanToThongTinKhachHang($idtaikhoan, $idkhachhang);
        if ($result == 1) {
            return true;
        }
        else {
            return false;
        }
    }
    private function LoadFormDangKy(){
        echo
        "
        <div class='container'>

        <div class='row vh-100 justify-content-center align-items-center'>
            <div class='col-sm-8 col-md-8 col-lg-6 shadow dky-ui'>
                <a class='row justify-content-center' href='./?to=trangchu'><img src='public/images/logo/logo.png' class='icon'></a>
                <div class='row dky-header'>
                    <h3>đăng ký tài khoản</h3>
                </div>


                <form class='dky-form' method='get' action='./'>
                    <input type='hidden' name='action' value='dangky'>
                    <input type='hidden' name='to' value='signup'>
                    <div class='row'>
                        <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                            <!--Họ-->
                            <div class='form-floating mb-3'>
                                <input type='text' class='form-control' name='ho' id='floatingInput' placeholder='họ'>
                                <label for='floatingInput'>Họ</label>
                            </div>
                        </div>
                        <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                            <!--Tên-->
                            <div class='form-floating mb-3'>
                                <input type='text' class='form-control' name='ten' id='floatingInput_Ten' placeholder='tên'>
                                <label for='floatingInput_Ten'>Tên</label>
                            </div>
                        </div>
                    </div>

                    <div class='form-floating mb-3'>
                        <input type='text' name='tendangnhap' class='form-control' id='floatingInput_Username' placeholder='Tên tài khoản'>
                        <label for='floatingInput_Username'>Tên đăng nhập</label>
                    </div>

                    <div class='row'>
                        <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                            <div class='form-floating mb-3'>
                                <input type='password' name='matkhau' class='form-control' id='floatingInput_Password' placeholder='Mật khẩu'>
                                <label for='floatingInput_Password'>Mật khẩu</label>
                            </div>
                        </div>
                        <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                            <div class='form-floating mb-3'>
                                <input type='password' name='nhaplaimatkhau' class='form-control' id='floatingInput_CPassword' placeholder='Nhập lại mật khẩu'>
                                <label for='floatingInput_CPassword'>Nhập lại mật khẩu</label>
                            </div>
                        </div>
                    </div>
                    <div class='form-floating mb-3'>
                        <input type='tel' name='sodienthoai' class='form-control' id='floatingInput_Pnumber' placeholder='Số điện thoại'>
                        <label for='floatingInput_Pnumber'>Số điện thoại</label>
                    </div>
                    <div class='form-floating mb-2'>
                        <input type='email' name='email' class='form-control' id='floatingInput_Email' placeholder='Email'>
                        <label for='floatingInput_Email'>Email</label>
                    </div>
                    <div class='form-check mb-3'>
                        <input class='form-check-input' name='chapnhan' type='checkbox' value='co' id='flexCheckDefault'>
                        <label class='form-check-label' for='flexCheckDefault'>
                            Chấp nhận với <span><a href=''>Điều khoản</a></span>
                        </label>
                    </div>
                    <button type='submit' name='dangky' class='dky-btn button mb-5'>Đăng ký</button>
                    <p>Bạn đã có tài khoản? <a href='./?to=login'><strong>Đăng nhập</strong></a></p>
                </form>
            </div>
        </div>
    </div>
        ";
    }
    private function LoadKetQuaDangKy()
    {
        echo
        "
        <div class='container'>

        <div class='row vh-100 justify-content-center align-items-center'>
            <div class='col-sm-8 col-md-8 col-lg-6 shadow dky-ui'>
                <a class='row justify-content-center' href='./?to=trangchu'><img src='public/images/logo/logo.png' class='icon'></a>
                <div class='row dky-header'>
                    <h3>đăng ký tài khoản</h3>
                </div>


                <form class='dky-form' method='get' action='./'>
                    <input type='hidden' name='action' value='dangky'>
                    <input type='hidden' name='to' value='signup'>
                    <div class='row'>
                        <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                            <!--Họ-->
                            <div class='form-floating mb-3'>
                                <input type='text' class='form-control' name='ho' id='floatingInput' placeholder='họ'>
                                <label for='floatingInput'>Họ</label>
                            </div>
                        </div>
                        <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                            <!--Tên-->
                            <div class='form-floating mb-3'>
                                <input type='text' class='form-control' name='ten' id='floatingInput_Ten' placeholder='tên'>
                                <label for='floatingInput_Ten'>Tên</label>
                            </div>
                        </div>
                    </div>

                    <div class='form-floating mb-3'>
                        <input type='text' name='tendangnhap' class='form-control' id='floatingInput_Username' placeholder='Tên tài khoản'>
                        <label for='floatingInput_Username'>Tên đăng nhập</label>
                    </div>

                    <div class='row'>
                        <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                            <div class='form-floating mb-3'>
                                <input type='password' name='matkhau' class='form-control' id='floatingInput_Password' placeholder='Mật khẩu'>
                                <label for='floatingInput_Password'>Mật khẩu</label>
                            </div>
                        </div>
                        <div class='col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'>
                            <div class='form-floating mb-3'>
                                <input type='password' name='nhaplaimatkhau' class='form-control' id='floatingInput_CPassword' placeholder='Nhập lại mật khẩu'>
                                <label for='floatingInput_CPassword'>Nhập lại mật khẩu</label>
                            </div>
                        </div>
                    </div>
                    <div class='form-floating mb-3'>
                        <input type='tel' name='sodienthoai' class='form-control' id='floatingInput_Pnumber' placeholder='Số điện thoại'>
                        <label for='floatingInput_Pnumber'>Số điện thoại</label>
                    </div>
                    <div class='form-floating mb-2'>
                        <input type='email' name='email' class='form-control' id='floatingInput_Email' placeholder='Email'>
                        <label for='floatingInput_Email'>Email</label>
                    </div>
                    <div class='form-check mb-3'>
                        <input class='form-check-input' name='chapnhan' type='checkbox' value='co' id='flexCheckDefault'>
                        <label class='form-check-label' for='flexCheckDefault'>
                            Chấp nhận với <span><a href=''>Điều khoản</a></span>
                        </label>
                    </div>
                    <button type='submit' name='dangky' class='dky-btn button mb-5'>Đăng ký</button>
                    <p>Bạn đã có tài khoản? <a href='./?to=login'><strong>Đăng nhập</strong></a></p>
                </form>
            </div>
        </div>
    </div>
        ";
    }
}