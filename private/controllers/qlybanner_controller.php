<?php
require_once("private/models/taikhoan_model.php");
require_once("private/models/banner_model.php");
require_once("private/modules/config.php");

class QuanLyBannerController{

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

                if($action == 'addbanner'){
                    if(isset($_POST['banner'])){
                        $this->AddBanner();
                    }else{
                        $this->LoadFormAddBanner();
                        return;
                    }
                }
                if($action == 'editbanner'){
                    if(isset($_POST['banner'])){
                        
                        $idbaner = $_GET['id'];
                        $this->CapNhatBanner($idbaner);
                    }else{
                        $idbaner = $_GET['id'];
                        $this->LoadFormEdit($idbaner);
                        return;
                        
                    }
                }
                if ($action =='delbanner'){
                    $this->XoaBanner(); 
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
            }$this->LoadQuanLyBanner();
        }
    private function LoadQuanLyBanner(){
        $bannerModel = new BannerModel;
        $banners = $bannerModel->LoadAllBanners();
        echo
        "
        <div class='container-fluid'>
        <div class='row mt-4'>";
        include('public/templates/dashboard.php');
        
        echo"
        
        <div class='col-lg-8 col-sm-12'>
        <div class='container-fluid'>
        <div class='row mt-4 mb-5'>
            <div class='ad-header'>
                <h3 id='ad-tit'>Quản lý banner</h3>
                <a href='?to=banner&amp;action=addbanner' class='ad-addbtn button'> + Thêm mới</a>
            </div>
        ";
        for ($i= 0; $i < count($banners) ; $i++){
            echo"<div class='row ad-banner' id='qlybn'>
                <div class='col-md-3 col-lg-2 col-xl-2 col-2'>
                    <img class='img-fluid' src='". $banners[$i]["diachianh"] . "'>
                </div>
                <div class='col-md-6 col-lg-8 col-xl-8 col-8 ad-bannerinfo'>
                    <p>".$banners[$i]["ten"]."</p>
                    <p>".$banners[$i]['trang']."</p>
                    <p>".$banners[$i]['mota']."</p>
                </div>
                <div class='col-md-3 col-lg-2 col-xl-2 col-2 ad-action '>
                    <a href='./?to=banner&amp;action=editbanner&id=".$banners[$i]["id_banner"]."' type='button' >
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z' />
                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z' />
                        </svg></a>
                    <a href='./?to=banner&amp;action=delbanner&id=".$banners[$i]["id_banner"]."' type='button'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'></path>
                            <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'></path>
                        </svg>
                    </a>
                </div>
                </div>
            ";

        }
    }
    private function AddBanner(){
        $banner = $_POST['banner'];
        $ten = $_POST['name'];
        $mota = $_POST['mota'];
        $trang = $_POST['trang'];
        $vitri = $_POST['vitri'];
        $value = $_POST['value'];
        $file =  $_FILES["anhbanner"];
        $fileTempname = $file["tmp_name"];
        $fileName = $file["name"];
        $fileError = $file['error'];
        $filesize = $file['size'];
        $duongdananh = "public/images/banners/".$fileName;
        $result = move_uploaded_file($fileTempname, $duongdananh);
        
        $fileExt = explode(".", $fileName);
        $fileActualExt = strtolower(end($fileExt));

        if($fileError == 0 ){
            if($filesize<9000000){
                if($result){
                    if(empty($ten) || empty($mota)){
                        echo "Cần phải nhập đầy đủ các thông tin!";
                    }   
                    else{
                        if(isset($banner)){
                               $bannerModel = new BannerModel;
                               $addbanner = $bannerModel->AddBanner($ten,$duongdananh,$mota,$trang,$value,$vitri);
                               header("Location: ?to=banner");
                            }
                        }
                    }
                else{
                    echo "Không thể upload ảnh";
                }
            }
            else{
                echo 'Kích thước file cần nhỏ hơn 7MB';
                exit();
            }
        }
        else{
            echo 'File lỗi!';
            exit();
        }
    
    }
    private function LoadFormAddBanner()
    {
       echo
        "
        <div class='container-fluid'>
        <div class='row mt-4'>";
        include('public/templates/dashboard.php');
        
        echo"
        <div class='col-lg-8 col-sm-12'>
        <div class='container-fluid'>
        <div class='row mt-4'>
            
            <div class='ad-header'>
                <h3 id='ad-tit'>Thêm mới banner</h3>
            </div>
        ";

        echo"
        <form class='container' method='post' enctype='multipart/form-data'>

                <input type='hidden' name='banner' value=''>
                <div class='row'>
                    <div class='col-12 col-lg-4 col-xl-4'>
                        <div class='form-floating mb-3'>
                            <input type='text' name='name' class='form-control' id='floatingInput_name' placeholder='Tên banner'>
                            <label for='floatingInput_name'>Tên banner</label>
                        </div>
                    </div>
                    <div class='col-12 col-lg-4 col-xl-4'>
                        <div class='form-floating mb-3'>
                        <select class='form-select' id='floatingSelect' aria-label='Floating label select example' name='trang'>
                            <option  value='trang chu'>Trang Chủ</option>
                            
                            <option  value='tim kiem'>Trang hiển thị tìm kiếm</option>
                            
                        </select>
                        <label for='floatingSelect'>Nằm ở trang</label>
                        </div>
                    </div>
                    <div class='col-12 col-lg-4 col-xl-4'>
                        <div class='form-floating mb-3'>
                        <select class='form-select' id='floatingSelect' aria-label='Floating label select example' name='vitri'>
                            <option  value='slider'>Trên</option>
                            <option  value='bot'>Dưới</option>
                            
                        </select>
                        <label for='floatingSelect'>Vị trí</label>
                        </div>
                    </div>
                </div>

                <div class='row'>
                <div class='col-lg-6 col-xl-6 col-12'>
                <div class='form-floating mb-3 col-12'>
                    <textarea class='pro-desc form-control' placeholder='Mô tả chi tiết' id='mota' name='mota'></textarea>
                    <label for='mota'>Giới thiệu</label>
                </div>
                </div>
                <div class='col-lg-6 col-xl-6 col-12 mt-2'>
                <div class='mb-3 col-12 '>
                    <label for='formFile' class='form-label'>Ảnh banner</label>
                    <input class='form-control' type='file' name='anhbanner' id='anhbanner' placeholder='Chọn Ảnh'>
                </div>
                <div class='col-12 '>
                        <div class='form-floating mb-3'>
                        <select class='form-select' id='floatingSelect' aria-label='Floating label select example' name='value'>
                            <option  value='0'>Áo thun</option>
                            <option  value='1'>Áo sơ mi</option>
                            <option  value='2'>Áo Khoác</option>
                            <option  value='3'>Quần Jean</option>
                            <option  value='4'>Quần Tây</option>
                            <option  value='5'>Quần Short</option>
                            <option  value='6'>Phụ kiện</option>
                        </select>
                        <label for='floatingSelect'>Sản phẩm sẽ hiển thị</label>
                        </div>
                    </div>
                </div>
                </div>
                <button type='submit' name='action' value='addbanner' class='button ad-addbtn2 mt-2'>Thêm banner</button>
        </div>
        </form>
        ";
    }
    private function XoaBanner(){
        $idbanner = $_GET["id"];
        $bannerModel = new BannerModel;
        $bannerModel->XoaBanner($idbanner);
    }
    private function CapNhatBanner($id){
        $bannerModel = new BannerModel;
        $bannerinfo = $bannerModel->LoadBannerInfo($id);
        $banner = $_POST['banner'];
        $ten = $_POST['name'];
        $mota = $_POST['mota'];
        $trang = $_POST['trang'];
        $vitri = $_POST['vitri'];
        $value = $_POST['value'];


        if(file_exists($_FILES["anhbanner"]['tmp_name'])){
            
            $file = $_FILES["anhbanner"]; 
            $fileTempname = $file["tmp_name"];
            $fileName = $file["name"];
            $fileError = $file["error"]; 
            $filesize = $file['size']; 
            $duongdananh = "public/images/banners/".$fileName;
            $result = move_uploaded_file($fileTempname, $duongdananh);
        }else{
            $duongdananh = $bannerinfo[0]['diachianh'];
            $fileError = 0; 
            $filesize = 0; 
            $result = true;
        }
        
        if($fileError == 0 ){
            if($filesize<9000000){
                if($result){
                    if(empty($ten) || empty($mota)){
                        echo "Cần phải nhập đầy đủ các thông tin!";
                    }   
                    else{
                        if(isset($banner)){
                               $bannerModel = new BannerModel;
                               $addbanner = $bannerModel->CapNhatBanner($id, $ten,$duongdananh,$mota,$trang,$vitri,$value);
                               header("Location: ?to=banner");
                            }
                        }
                    }
                else{
                    echo "Không thể upload ảnh";
                }
            }
            else{
                echo 'Kích thước file cần nhỏ hơn 7MB';
                exit();
            }
        }
        else{
            echo 'File lỗi!';
            exit();
        }
    
    }
    private function LoadFormEdit($id){
        $bannerModel = new BannerModel;
        $bannerinfo = $bannerModel->LoadBannerInfo($id);
        echo
        "
        <div class='container-fluid'>
        <div class='row mt-4'>";
        include('public/templates/dashboard.php');
        
        echo"
        <div class='col-lg-8 col-sm-12'>
        <div class='container-fluid'>
        <div class='row mt-4'>
            
            <div class='ad-header'>
                <h3 id='ad-tit'>Chỉnh sửa banner</h3>
            </div>
        ";

        echo"
        <form class='container' method='post' enctype='multipart/form-data'>

                <input type='hidden' name='banner' value=''>
                <div class='row'>
                    <div class='col-12 col-lg-4 col-xl-4'>
                        <div class='form-floating mb-3'>
                            <input type='text' name='name' class='form-control' id='floatingInput_name' value='".$bannerinfo[0]['ten']."'placeholder='Tên banner'>
                            <label for='floatingInput_name'>Tên banner</label>
                        </div>
                    </div>
                    <div class='col-12 col-lg-4 col-xl-4'>
                        <div class='form-floating mb-3'>
                        <select class='form-select' id='floatingSelect' aria-label='Floating label select example' name='trang'>
                            <option  value='trang chu'>Trang Chủ</option>
                            
                         <option  value='tim kiem'>Trang hiển thị tìm kiếm</option>
                            
                         </select>
                        <label for='floatingSelect'>Nằm ở trang</label>
                        </div>
                    </div>
                    <div class='col-12 col-lg-4 col-xl-4'>
                        <div class='form-floating mb-3'>
                        <select class='form-select' id='floatingSelect' aria-label='Floating label select example' name='vitri'>
                            <option  value='slider'>Trên</option>
                            <option  value='bot'>Dưới</option>
                            
                        </select>
                        <label for='floatingSelect'>Vị trí</label>
                        </div>
                    </div>
                </div>

                <div class='row'>
                <div class='col-lg-6 col-xl-6 col-12'>
                <div class='form-floating mb-3 col-12'>
                    <textarea class='pro-desc form-control' placeholder='Mô tả chi tiết' id='mota' name='mota'>".$bannerinfo[0]['mota']."</textarea>
                    <label for='mota'>Giới thiệu</label>
                </div>
                </div>
                <div class='col-lg-6 col-xl-6 col-12 mt-2'>
                
                <div class='mb-3 col-12 '>
                    <label for='formFile' class='form-label'>Ảnh banner</label>
                    <img class='w-100 mb-3' src='".$bannerinfo[0]['diachianh']."'>
                    <input class='form-control' type='file' name='anhbanner' id='anhbanner' placeholder='Chọn Ảnh'>
                </div>
                <div class='col-12 '>
                        <div class='form-floating mb-3'>
                        <select class='form-select' id='floatingSelect' aria-label='Floating label select example' name='value'>
                            <option  value='0'>Áo thun</option>
                            <option  value='1'>Áo sơ mi</option>
                            <option  value='2'>Áo Khoác</option>
                            <option  value='3'>Quần Jean</option>
                            <option  value='4'>Quần Tây</option>
                            <option  value='5'>Quần Short</option>
                            <option  value='6'>Phụ kiện</option>
                        </select>
                        <label for='floatingSelect'>Sản phẩm sẽ hiển thị</label>
                        </div>
                    </div>
                </div>
                </div>
                <button type='submit' name='action' value='editbanner' class='button ad-addbtn2 mt-2'>Cập nhật banner</button>
        </div>
        </form>
        ";
    }
}

?>