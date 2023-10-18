<?php
require_once("private/models/taikhoan_model.php");
require_once("private/models/sanpham_model.php");
require_once("private/modules/config.php");
class QuanLySanPhamController
{
    public function LoadPage()
    {
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
                if($action == 'locsanpham'){
                    $iddanhmuc = $_GET['danhmuc'];
                    $this->LoadQuanLySanPhamTheoDanhMuc($iddanhmuc);
                    exit();
                }
                if($action == 'timkiem'){
                    $key = $_GET['key'];
                    $this->LoadQuanLySanPhamTheoTen($key);
                    exit();
                }
                if($action == 'addsp'){
                    if(isset($_POST['sanpham'])){
                        $this->AddSanPham();
                    }else{
                        $this->LoadFormAddSanPham();
                        return;
                    }
                }
                
                if($action == 'editsp'){
                    if(isset($_POST['sanpham'])){
                        
                        $idsanpham = $_GET['id_sanpham'];
                        $this->CapNhatSanPhamInfo($idsanpham);
                    }else{
                        $idsanpham = $_GET['id_sanpham'];
                        $this->LoadFormEdit($idsanpham);
                        return;
                        
                    }
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
                
                if ($action =='delproduct'){
                    $this->XoaSanPham(); 
                    header("Location: ?to=admin");
                }
                if ($action =='sale'){
                    if(isset($_GET['giagiam'])){
                        $giagiam = $_GET['giagiam'];
                        $idsanpham = $_GET['id'];
                        $this->GiamGia($idsanpham,$giagiam);
                    }else{

                        $this->LoadQuanLySanPham();
                    }
                }
                if($action =='xoagiamgia'){
                    $this->XoaGiamGia();
                }
            }$this->LoadQuanLySanPham();
        }
            
        
    }

    private function LoadQuanLySanPham()
    {
        $sanPhamModel = new SanPhamModel();
        $sanPham = $sanPhamModel->LoadAll();
        echo
        "
        <div class='container-fluid'>
        <div class='row mt-4'>";
        include('public/templates/dashboard.php');
        echo "
        <div class='col-lg-8 col-sm-12'>
        <div class='ad-searchbar' id='search-bar'>
            <form class='d-flex justify-content-center'>
                <input type='hidden' name='to' value='admin'>
                
                <input type='hidden' name='action' value='timkiem'>
                <input type='text' name='key' class='ad-search-box' placeholder='Tìm kiếm'>
                <button type='submit' class='search-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                        <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z' />
                    </svg>
                </button>
            </form>
        </div>
        <div class='ad-header'>
            <h3 id='ad-tit'>Quản lý sản phẩm</h3>
            <a href='?to=admin&amp;action=addsp' class='ad-addbtn button'> + Thêm mới</a>
        </div>
        <div class='filter mb-3'>
        <form method='get'>
        <div class='form-floating '>
        <input type='hidden' name='to' value='admin'>
        <input type='hidden' name='action' value='locsanpham'>";
        $this->LoadDanhMuc('none');
            echo"
        </div>
    <button type='submit' class='filterbtn button'>Lọc</button>
    </form>
        </div>
        ";
        for ($i= 0; $i < count($sanPham) ; $i++) {
            $sanphaminfo = $sanPhamModel->LoadSanPhamInFo($sanPham[$i]["id_sanpham"]);
            if(isset($sanphaminfo[0]['giagiam'])){
                
                echo"<div class='row ad-product' id='qlysp'>

                <div class='col-md-3 col-lg-2 col-xl-2 col-2'>
                    <a href='./?to=detail&id=" . $sanPham[$i]["id_sanpham"] . "'>
                        <img class='img-fluid' src='". $sanPham[$i]["anhchinh"] . "'>
                    </a>
                </div>
        
                <div class='col-md-6 col-lg-8 col-xl-8 col-8 ad-proinfo'>
                    <h4>".$sanPham[$i]["ten"]."</h4>
                    <p>".$sanphaminfo[0]['tendanhmuc']."</p>
                    <span style='color:red'>".number_format($sanphaminfo[0]["giagiam"], 0, ',', ',')."₫</span>
                    <del>".number_format($sanPham[$i]["gia"],0,',',',') ."₫</del>
                </div>
                <div class='col-md-3 col-lg-2 col-xl-2 col-2 ad-action '>
                    <span class='sale-icon' onclick='toggleSaleForm($i)'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-tags' viewBox='0 0 16 16'>
                            <path d='M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z'/>
                            <path d='M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z'/>
                        </svg>
                    </span>
                    <a href='./?to=admin&amp;action=editsp&id_sanpham=".$sanPham[$i]["id_sanpham"]."' type='button' >
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z' />
                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z' />
                        </svg></a>
                    <a href='./?to=admin&amp;action=delproduct&id_sanpham=".$sanPham[$i]["id_sanpham"]."' type='button'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'></path>
                            <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'></path>
                        </svg>
                    </a>
                </div>
                <div class='col-12 saleform' >
                    <form  method='get' action='./'>
                    <input type='hidden' name='to' value='admin'>
                    <input type='hidden' name='action' value='sale'>
                    <input type='hidden' name='id' value='".$sanPham[$i]["id_sanpham"]."'>
                    <label for='sale'>Giá sẽ giảm của <strong>".$sanPham[$i]["ten"]." </strong>:</label>
                    <input type='number' id='sale' name='giagiam'>
                    <button type='submit' class='button adsalebtn' >Giảm Giá</button>
                    </form>
                <a href='./?to=admin&amp;action=xoagiamgia&id_sanpham=".$sanPham[$i]["id_sanpham"]."'>Xóa khuyến mãi</a>
                </div>
            </div>
           ";
            }else{
                echo"<div class='row ad-product' id='qlysp'>

                <div class='col-md-3 col-lg-2 col-xl-2 col-2'>
                    <a href='./?to=detail&id=" . $sanPham[$i]["id_sanpham"] . "'>
                        <img class='img-fluid' src='". $sanPham[$i]["anhchinh"] . "'>
                    </a>
                </div>
        
                <div class='col-md-6 col-lg-8 col-xl-8 col-8 ad-proinfo'>
                    <h4>".$sanPham[$i]["ten"]."</h4>
                    <p>".$sanphaminfo[0]['tendanhmuc']."</p>
                    <span>". number_format($sanPham[$i]["gia"],0,',',',') ."₫</span>
                    <del></del>
                </div>
                <div class='col-md-3 col-lg-2 col-xl-2 col-2 ad-action '>
                    <span class='sale-icon' onclick='toggleSaleForm($i)'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-tags' viewBox='0 0 16 16'>
                            <path d='M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z'/>
                            <path d='M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z'/>
                        </span>
                    </button>
                    <a href='./?to=admin&amp;action=editsp&id_sanpham=".$sanPham[$i]["id_sanpham"]."' type='button'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z' />
                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z' />
                        </svg></a>
                    <a href='./?to=admin&amp;action=delproduct&id_sanpham=".$sanPham[$i]["id_sanpham"]."' type='button'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'></path>
                            <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'></path>
                        </svg>
                    </a>
                </div>
                <div class='col-12 saleform' >
                    <form  method='get' action='./'>
                    <input type='hidden' name='to' value='admin'>
                    <input type='hidden' name='action' value='sale'>
                    <input type='hidden' name='id' value='".$sanPham[$i]["id_sanpham"]."'>
                    <label for='sale'>Giá sẽ giảm của <strong>".$sanPham[$i]["ten"]." </strong>:</label>
                    <input type='number' id='sale' name='giagiam'>
                    <button type='submit' class='button adsalebtn' >Giảm Giá</button>
                    </form>
                <a href='./?to=admin&amp;action=xoagiamgia&id_sanpham=".$sanPham[$i]["id_sanpham"]."'>Xóa khuyến mãi</a>
                </div>
            </div>
           ";

            }

        }
    }
    private function XoaSanPham(){
        $id_sanpham = $_GET["id_sanpham"];
        $sanPhamModel = new SanPhamModel();
        $sanPhamModel->XoaSanPham($id_sanpham);
    }
    private function GiamGia($idsanpham,$giagiam){
        $sanPhamModel = new SanPhamModel();
        $sanPhamModel->CapNhatGiamGia($idsanpham,$giagiam);
    }
    private function XoaGiamGia(){
        $id_sanpham = $_GET["id_sanpham"];
        $sanPhamModel = new SanPhamModel();
        $sanPhamModel->XoaGiamGia($id_sanpham);
    }
    public function LoadFormAddSanPham(){

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
                <h3 id='ad-tit'>Thêm mới sản phẩm</h3>
            </div>
        ";

        echo"
        <form class='container' method='post' enctype='multipart/form-data'>

                <input type='hidden' name='sanpham' value=''>
                <div class='row'>
                    <div class='col-12 col-lg-4 col-xl-4'>
                        <div class='form-floating mb-3'>
                            <input type='text' name='name' class='form-control' id='floatingInput_name' placeholder='Tên sản phẩm'>
                            <label for='floatingInput_name'>Tên sản phẩm</label>
                        </div>
                    </div>
                    <div class='col-12 col-lg-3 col-xl-3'>
                        <div class='form-floating mb-3'>
                            <input type='number' name='price' class='form-control' id='floatingInput_price' placeholder='Giá niêm yết'>
                            <label for='floatingInput_price'>Giá niêm yết</label>
                        </div>
                    </div>
                    <div class='form-floating mb-3 col-lg-2 col-xl-2 col-12'>
                <input class='form-control' type='date' name='ngaynhap' id='ngaynhap' placeholder='dd-mm-yyyy'>
                    <label style='left:9px;' for='ngaynhap'>Ngày nhập hàng</label>
                </div>
                    <div class='col-12 col-lg-3 col-xl-3'>
                    <div class='form-floating mb-3'>";
                      
                    $this->LoadDanhMuc('none');

                    echo "
                    </div>
                    </div>
                </div>

                <div class='row'>
                <div class='col-lg-6 col-xl-6 col-12'>
                <div class='col-12'>
                <label for='size'>Size</label>
                <div class='size'>
                            <input type='checkbox' class='size-icon' name='size[]' id='xs' value='XS' autocomplete='off'>
                            <label class='size-label' for='xs'>XS</label>

                            <input type='checkbox' class='size-icon' name='size[]' id='s' value='S' autocomplete='off'>
                            <label class='size-label' for='s'>S</label>

                            <input type='checkbox' class='size-icon' name='size[]' id='m' value='M' autocomplete='off' >
                            <label class='size-label' for='m'>M</label>

                            <input type='checkbox' class='size-icon' name='size[]' id='l' value='L' autocomplete='off' >
                            <label class='size-label' for='l'>L</label>

                            <input type='checkbox' class='size-icon' name='size[]' id='xl' value='XL' autocomplete='off' >
                            <label class='size-label' for='xl'>XL</label>

                            <input type='checkbox' class='size-icon' name='size[]' id='pk' value='PK' autocomplete='off' >
                            <label class='size-label' for='pk'>PK</label>
                        </div>
                </div>
                <div class='form-floating mb-3 col-12'>
                    <textarea class='pro-desc form-control' placeholder='Mô tả chi tiết' id='description' name='description'></textarea>
                    <label for='description'>Giới thiệu</label>
                </div>
                </div>
                <div class='col-lg-6 col-xl-6 col-12 mt-2'>
                <div class='mb-3 col-12 '>
                    <label for='formFile' class='form-label'>Ảnh chính sản phẩm</label>
                    <input class='form-control' type='file' name='mainimg' id='anhchinh' placeholder='Chọn Ảnh'>
                </div>
                <div class='row'>
                <div class='col-6 mb-3'>
                    <label for='formFile' class='form-label'>Ảnh 1 sản phẩm</label>
                    <input class='form-control' type='file' name='img1' id='anh1' placeholder='Chọn Ảnh'>
                </div>
                <div class='col-6 mb-3'>
                    <label for='formFile' class='form-label'>Ảnh 2 sản phẩm</label>
                    <input class='form-control' type='file' name='img2' id='anh2' placeholder='Chọn Ảnh'>
                </div>
                </div>
               <div class='row'>
               <div class='col-6 mb-3'>
                    <label for='formFile' class='form-label'>Ảnh 3 sản phẩm</label>
                    <input class='form-control' type='file' name='img3' id='anh3' placeholder='Chọn Ảnh'>
                </div>
                <div class='mb-3 col-6'>
                    <label for='formFile' class='form-label'>Ảnh 4 sản phẩm</label>
                    <input class='form-control' type='file' name='img4' id='anh4' placeholder='Chọn Ảnh'>
                </div>
               </div>
                
                </div>
                </div>
                <button type='submit' name='action' value='addsp' class='button ad-addbtn2 mt-2'>Thêm sản phẩm</button>
        </div>
        </form>
        </div>
        ";

    }
    public function UpLoadAnh($img){
        $file = $img;
        $fileTempname = $file["tmp_name"];
        $fileName = $file["name"];
        $duongdananh = "public/images/products/".$fileName;
        $up = move_uploaded_file($fileTempname, $duongdananh);
        $imgarr = array($duongdananh, $up);
        return $imgarr;
    }
    private function AddSanPham(){
        $sanpham = $_POST['sanpham'];
        $ten = $_POST['name'];
        $gia = $_POST['price'];
        $danhmuc = $_POST['danhmuc'];
        $gioithieu = $_POST['description'];
        $ngaynhap = $_POST['ngaynhap'];
        $size = $_POST['size'];
        $anhchinh = $_FILES["mainimg"];             $anh1 = $_FILES['img1'];            $anh2 = $_FILES['img2'];            $anh3 = $_FILES['img3'];            $anh4 = $_FILES['img4'];        
        $anhchinhname = $anhchinh['name'];          $anh1name = $anh1['name'];          $anh2name = $anh2['name'];          $anh3name = $anh3['name'];          $anh4name = $anh4['name'];
		$anhchinhError = $anhchinh["error"];        $anh1Error = $anh1["error"];        $anh2Error = $anh2["error"];        $anh3Error = $anh3["error"];        $anh4Error = $anh4["error"];
        $anhchinhsize = $anhchinh['size'];          $anh1size = $anh1['size'];          $anh2size = $anh2['size'];          $anh3size = $anh3['size'];          $anh4size = $anh4['size'];

        $fileExt = explode(".", $anhchinhname);
        $fileActualExt = strtolower(end($fileExt));

        
		$allow = array("jpg", "png", "jpeg");

        if(in_array($fileActualExt, $allow)){
			if($anhchinhError == 0 && $anh1Error == 0 && $anh2Error == 0 && $anh3Error == 0&& $anh4Error == 0 ){
				if($anhchinhsize<10000000 && $anh1size<10000000 && $anh2size<10000000 && $anh3size<10000000 && $anh4size<10000000 ){
                    $upmain = $this->UpLoadAnh($anhchinh);
                    $up1 = $this->UpLoadAnh($anh1);
                    $up2 = $this->UpLoadAnh($anh2);
                    $up3 = $this->UpLoadAnh($anh3);
                    $up4 = $this->UpLoadAnh($anh4);
					if($upmain[1] && $up1[1] && $up2[1] && $up3[1] && $up4[1]){
						if(empty($ten) || empty($gia)){
							echo "Cần phải nhập đầy đủ các thông tin!";
						}
						else{
							if(isset($sanpham)){
									$sanPhamModel = new SanPhamModel();
									$idsanpham =  $sanPhamModel->ThemSanPham($ten, $gia, $ngaynhap, $gioithieu, $upmain[0],$up1[0],$up2[0],$up3[0],$up4[0]); 
                                    $sanPhamModel->ThemDanhMucChoSanPham($idsanpham,$danhmuc);
                                    for($i = 0; $i < count($size); $i++){
                                        $sanPhamModel->ThemSizeChoSanPham($idsanpham,$size[$i]);
                                    }
                                    header("Location: ?to=admin");
								}
							}
						}
					else{
						echo "Không thể upload ảnh";
					}
				}
				else{
					echo 'Kích thước file cần nhỏ hơn 5MB';
					exit();
				}
			}
			else{
				echo 'File lỗi!';
				exit();
			}
        }
		else{
			echo 'Cần upload đúng kiểu file png hoặc jpg';
			exit();
		}
    }
    public function LoadDanhMuc($iddm){
		$baidangbanModel = new SanPhamModel();
		$danhmuc = $baidangbanModel->LoadDanhMucSanPham();

		echo '
		<select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="danhmuc">';
		for($i = 0; $i < count($danhmuc); $i++){
            if($danhmuc[$i]["id_danhmuc"] == $iddm){
                echo '
                <option  value="'.$danhmuc[$i]["id_danhmuc"].'" selected>'.$danhmuc[$i]["tendanhmuc"].'</option>
                ';
            }else
			echo '
			<option  value="'.$danhmuc[$i]["id_danhmuc"].'">'.$danhmuc[$i]["tendanhmuc"].'</option>
			';
		}
		echo '
			</select>
           	<label for="floatingSelect">Danh mục</label>
		';
    }
    private function CapNhatSanPhamInfo($idsanpham){
        $sanPhamModel = new SanPhamModel;
        $product = $sanPhamModel->LoadSanPhamInFo($idsanpham);

        $sanpham = $_POST['sanpham'];
        $ten = $_POST['name'];
        $gia = $_POST['price'];
        $danhmuc = $_POST['danhmuc'];
        $gioithieu = $_POST['description'];
        $ngaynhap = $_POST['ngaynhap'];
        $size = $_POST['size'];

        if(file_exists($_FILES["mainimg"]['tmp_name'])){
            $anhchinh = $_FILES["mainimg"];   
            $anhchinhError = $anhchinh["error"]; 
            $anhchinhsize = $anhchinh['size'];  
            $upmain = $this->UpLoadAnh($anhchinh);
        }else{
            $anhchinh = 0;
            $anhchinhError = 0; 
            $anhchinhsize = 0;  
            $upmain = array($product[0]['anhchinh'],true);
        }
        if(file_exists($_FILES["img1"]['tmp_name'])){
            $anh1 = $_FILES['img1']; 
            $anh1Error = $anh1["error"];
            $anh1size = $anh1['size'];
            $up1 = $this->UpLoadAnh($anh1);
        }else{  
            $anh1Error = 0;
            $anh1size = 0;
            $up1 = array($product[0]['anhphu1'],true);
        }
        if(file_exists($_FILES["img2"]['tmp_name'])){
            $anh2 = $_FILES['img2']; 
            $anh2Error = $anh2["error"];
            $anh2size = $anh2['size'];
            $up2 = $this->UpLoadAnh($anh2);
        }else{  
            $anh2Error = 0;
            $anh2size = 0;
            $up2 = array($product[0]['anhphu2'],true);
        }
        if(file_exists($_FILES["img3"]['tmp_name'])){
            $anh3 = $_FILES['img3']; 
            $anh3Error = $anh3["error"];
            $anh3size = $anh3['size'];
            $up3 = $this->UpLoadAnh($anh3);
        }else{  
            $anh3Error = 0;
            $anh3size = 0;
            $up3 = array($product[0]['anhphu3'],true);
        }
        if(file_exists($_FILES["img4"]['tmp_name'])){
            $anh4 = $_FILES['img4']; 
            $anh4Error = $anh4["error"];
            $anh4size = $anh4['size'];
            $up4 = $this->UpLoadAnh($anh4);
        }else{  
            $anh4Error = 0;
            $anh4size = 0;
            $up4 = array($product[0]['anhphu4'],true);
        }

			if($anhchinhError == 0 && $anh1Error == 0 && $anh2Error == 0 && $anh3Error == 0  && $anh4Error == 0 ){
				if($anhchinhsize<1000000 && $anh1size<1000000 && $anh2size<1000000 && $anh3size<1000000 && $anh4size<1000000 ){
					if($upmain[1] && $up1[1] && $up2[1] && $up3[1] && $up4[1]){
						if(empty($ten) || empty($gia)){
							echo "Cần phải nhập đầy đủ các thông tin!";
						}
						else{
							if(isset($sanpham)){
									$sanPhamModel = new SanPhamModel();
									$sanPhamModel->CapNhatSanPhamInfo($idsanpham,$ten, $gia, $ngaynhap, $gioithieu, $upmain[0],$up1[0],$up2[0],$up3[0],$up4[0]); 
                                    $sanPhamModel->CapNhatDanhMuc($idsanpham,$danhmuc);
                                    $sanPhamModel->XoaSize($idsanpham);
                                    for($i = 0; $i < count($size); $i++){
                                        $sanPhamModel->ThemSizeChoSanPham($idsanpham,$size[$i]);
                                    }
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
    private function LoadSize($idsanpham, $size){
        $sanPhamModel = new SanPhamModel();
        $sanpham = $sanPhamModel->LoadSanPhamInFo($idsanpham);
        $sizes = array();
        foreach ($sanpham as $key => $value) {
            array_push($sizes, $value["size"]);
        }
        $hienthisize ='';
        
        if(in_array($size,$sizes)){
            $hienthisize .= "<input type='checkbox' class='size-icon' name='size[]' id='$size' value='$size' autocomplete='off' checked=''>
            <label class='size-label' for='$size'>$size</label>";
        }else {
            $hienthisize .= "<input type='checkbox' class='size-icon' name='size[]' id='$size' value='$size' autocomplete='off' >
            <label class='size-label' for='$size'>$size</label>";
        }
        return $hienthisize;
    }
    private function LoadFormEdit($idsanpham){
        $sanPhamModel = new SanPhamModel;
        $sanphaminfo = $sanPhamModel->LoadSanPhamInFo($idsanpham);

        
        echo
        "
        <div class='container-fluid'>
        <div class='row mt-4'>";
        include('public/templates/dashboard.php');
        
        echo"
        <div class='col-lg-8 col-sm-12'>
        <div class='container-fluid'>
        <div class='row mt-4 mb-5'>
            <?php
            include('public/templates/dashboard.php');
            ?>
            <div class='ad-header'>
                <h3 id='ad-tit'>Cập nhật thông tin sản phẩm</h3>
               
            </div>
        ";

        echo"
        <form class='container' method='post' enctype='multipart/form-data'>

                <input type='hidden' name='sanpham' value=''>
                <div class='row'>
                <div class='col-lg-6 col-xl-6 col-12'>
                <div class='form-floating mb-3'>
                            <input type='text' name='name' class='form-control' id='floatingInput_name' placeholder='Tên sản phẩm' value='".$sanphaminfo[0]['ten']."'>
                            <label for='floatingInput_name'>Tên sản phẩm</label>
                        </div>
                        <div class='form-floating mb-3'>
                            <input type='number' name='price' class='form-control' id='floatingInput_price' placeholder='Giá niêm yết' value='".$sanphaminfo[0]['gia']."'>
                            <label for='floatingInput_price'>Giá niêm yết</label>
                        </div>
                        <div class='form-floating mb-3 '>
                            <input class='form-control' type='date' name='ngaynhap' id='ngaynhap' placeholder='mm-dd-yyyy' value='".$sanphaminfo[0]['ngaynhap']."'>
                            <label style='left:9px;' for='ngaynhap'>Ngày nhập hàng</label>
                        </div>
                        <div class='form-floating mb-3'>";
                    $this->LoadDanhMuc($sanphaminfo[0]['id_danhmuc']);
                    echo "
                    </div>
                <div class='col-12'>
                <label for='size'>Size</label>
                <div class='size'>
                ".$this->LoadSize($idsanpham,'XS')."
                ".$this->LoadSize($idsanpham,'S')."
                ".$this->LoadSize($idsanpham,'M')."
                ".$this->LoadSize($idsanpham,'L')."
                ".$this->LoadSize($idsanpham,'XL')."
                ".$this->LoadSize($idsanpham,'PK')."
                </div>
                </div> 
                <div class='form-floating mb-3 col-12'>
                    <textarea class='pro-desc form-control' placeholder='Mô tả chi tiết' id='description' name='description'>".$sanphaminfo[0]['gioithieu']."</textarea>
                    <label for='description'>Giới thiệu</label>
                </div>
                </div>
                <div class='col-lg-6 col-xl-6 col-12 mt-2'>
                
                <label for='formFile' class='form-label'>Ảnh chính sản phẩm</label>
                <div class='mb-3 edit-img-form'>
                    <img src='".$sanphaminfo[0]['anhchinh']."' alt='' class='edit-img'>
                    <input class='form-control edit-inputimg' type='file' name='mainimg' id='anhchinh' placeholder='Chọn Ảnh'>
                </div>
                <label for='formFile' class='form-label'>Ảnh 1 </label>
                <div class='mb-3 edit-img-form'>
                    <img src='".$sanphaminfo[0]['anhphu1']."' alt='' class='edit-img'>
                    <input class='form-control edit-inputimg' type='file' name='img1' id='anh1' placeholder='Chọn Ảnh'>
                </div>
                <label for='formFile' class='form-label'>Ảnh 2</label>
                <div class='mb-3 edit-img-form'>
                    <img src='".$sanphaminfo[0]['anhphu2']."' alt='' class='edit-img'>
                    <input class='form-control edit-inputimg' type='file' name='img2' id='anh2' placeholder='Chọn Ảnh'>
                </div>
                <label for='formFile' class='form-label'>Ảnh 3</label>
                <div class='mb-3 edit-img-form'>
                    <img src='".$sanphaminfo[0]['anhphu3']."' alt='' class='edit-img'>
                    <input class='form-control edit-inputimg' type='file' name='img3' id='anh3' placeholder='Chọn Ảnh'>
                </div>
                <label for='formFile' class='form-label'>Ảnh 4</label>
                <div class='mb-3 edit-img-form'>
                    <img src='".$sanphaminfo[0]['anhphu4']."' alt='' class='edit-img'>
                    <input class='form-control edit-inputimg' type='file' name='img4' id='anh4' placeholder='Chọn Ảnh'>
                </div>
                
                
                </div>
                </div>
                <button type='submit' name='action' value='editsp' class='button ad-addbtn2 '>Cập nhật sản phẩm</button>
        </div>
        </form>
        </div>
        ";
    }
    public function LoadQuanLySanPhamTheoDanhMuc($iddanhmuc){
        $sanPhamModel = new SanPhamModel();
        $sanPham = $sanPhamModel->LoadSanPhamTheoDanhMuc($iddanhmuc);
        echo
        "
        <div class='container-fluid'>
        <div class='row mt-4'>";
        include('public/templates/dashboard.php');
        echo "
        <div class='col-lg-8 col-sm-12'>
        <div class='ad-searchbar' id='search-bar'>
            <form class='d-flex justify-content-center'>
                <input type='hidden' name='to' value='admin'>
                
                <input type='hidden' name='action' value='timkiem'>
                <input type='text' name='key' class='ad-search-box' placeholder='Tìm kiếm'>
                <button type='submit' class='search-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                        <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z' />
                    </svg>
                </button>
            </form>
        </div>

        <div class='ad-header'>
            <h3 id='ad-tit'>Quản lý sản phẩm</h3>
            <a href='?to=admin&amp;action=addsp' class='ad-addbtn button'> + Thêm mới</a>
        </div>
        <div class='filter mb-3'>
        <form method='get'>
        <div class='form-floating '>
        <input type='hidden' name='to' value='admin'>
        <input type='hidden' name='action' value='locsanpham'>";
        $this->LoadDanhMuc($iddanhmuc);
            echo"
        </div>
    <button type='submit' class='filterbtn button'>Lọc</button>
    </form>
        </div>
        ";
        for ($i= 0; $i < count($sanPham) ; $i++) {
            $sanphaminfo = $sanPhamModel->LoadSanPhamInFo($sanPham[$i]["id_sanpham"]);
            if(isset($sanphaminfo[0]['giagiam'])){
                
                echo"<div class='row ad-product' id='qlysp'>

                <div class='col-md-3 col-lg-2 col-xl-2 col-2'>
                    <a href='./?to=detail&id=" . $sanPham[$i]["id_sanpham"] . "'>
                        <img class='img-fluid' src='". $sanPham[$i]["anhchinh"] . "'>
                    </a>
                </div>
        
                <div class='col-md-6 col-lg-8 col-xl-8 col-8 ad-proinfo'>
                    <h4>".$sanPham[$i]["ten"]."</h4>
                    <p>".$sanphaminfo[0]['tendanhmuc']."</p>
                    <span style='color:red'>".number_format($sanphaminfo[0]["giagiam"], 0, ',', ',')."₫</span>
                    <del>".number_format($sanPham[$i]["gia"],0,',',',') ."₫</del>
                </div>
                <div class='col-md-3 col-lg-2 col-xl-2 col-2 ad-action '>
                    <span class='sale-icon' onclick='toggleSaleForm($i)'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-tags' viewBox='0 0 16 16'>
                            <path d='M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z'/>
                            <path d='M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z'/>
                        </svg>
                    </span>
                    <a href='./?to=admin&amp;action=editsp&id_sanpham=".$sanPham[$i]["id_sanpham"]."' type='button' >
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z' />
                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z' />
                        </svg></a>
                    <a href='./?to=admin&amp;action=delproduct&id_sanpham=".$sanPham[$i]["id_sanpham"]."' type='button'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'></path>
                            <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'></path>
                        </svg>
                    </a>
                </div>
                <div class='col-12 saleform' >
                    <form  method='get' action='./'>
                    <input type='hidden' name='to' value='admin'>
                    <input type='hidden' name='action' value='sale'>
                    <input type='hidden' name='id' value='".$sanPham[$i]["id_sanpham"]."'>
                    <label for='sale'>Giá sẽ giảm của <strong>".$sanPham[$i]["ten"]." </strong>:</label>
                    <input type='number' id='sale' name='giagiam'>
                    <button type='submit' class='button adsalebtn' >Giảm Giá</button>
                    </form>
                <a href='./?to=admin&amp;action=xoagiamgia&id_sanpham=".$sanPham[$i]["id_sanpham"]."'>Xóa khuyến mãi</a>
                </div>
            </div>
           ";
            }else{
                echo"<div class='row ad-product' id='qlysp'>

                <div class='col-md-3 col-lg-2 col-xl-2 col-2'>
                    <a href='./?to=detail&id=" . $sanPham[$i]["id_sanpham"] . "'>
                        <img class='img-fluid' src='". $sanPham[$i]["anhchinh"] . "'>
                    </a>
                </div>
        
                <div class='col-md-6 col-lg-8 col-xl-8 col-8 ad-proinfo'>
                    <h4>".$sanPham[$i]["ten"]."</h4>
                    <p>".$sanphaminfo[0]['tendanhmuc']."</p>
                    <span>". number_format($sanPham[$i]["gia"],0,',',',') ."₫</span>
                    <del></del>
                </div>
                <div class='col-md-3 col-lg-2 col-xl-2 col-2 ad-action '>
                    <span class='sale-icon' onclick='toggleSaleForm($i)'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-tags' viewBox='0 0 16 16'>
                            <path d='M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z'/>
                            <path d='M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z'/>
                        </span>
                    </button>
                    <a href='./?to=admin&amp;action=editsp&id_sanpham=".$sanPham[$i]["id_sanpham"]."' type='button'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z' />
                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z' />
                        </svg></a>
                    <a href='./?to=admin&amp;action=delproduct&id_sanpham=".$sanPham[$i]["id_sanpham"]."' type='button'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'></path>
                            <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'></path>
                        </svg>
                    </a>
                </div>
                <div class='col-12 saleform' >
                    <form  method='get' action='./'>
                    <input type='hidden' name='to' value='admin'>
                    <input type='hidden' name='action' value='sale'>
                    <input type='hidden' name='id' value='".$sanPham[$i]["id_sanpham"]."'>
                    <label for='sale'>Giá sẽ giảm của <strong>".$sanPham[$i]["ten"]." </strong>:</label>
                    <input type='number' id='sale' name='giagiam'>
                    <button type='submit' class='button adsalebtn' >Giảm Giá</button>
                    </form>
                <a href='./?to=admin&amp;action=xoagiamgia&id_sanpham=".$sanPham[$i]["id_sanpham"]."'>Xóa khuyến mãi</a>
                </div>
            </div>
            <script src='public/scripts/admin.js'></script>
           ";

            }

        }
    }
    private function LoadQuanLySanPhamTheoTen($key)
    {
        $sanPhamModel = new SanPhamModel();
        $sanPham = $sanPhamModel->LoadSanPhamTheoTenHoacLoai($key);
        echo
        "
        <div class='container-fluid'>
        <div class='row mt-4'>";
        include('public/templates/dashboard.php');
        echo "
        <div class='col-lg-8 col-sm-12'>
        <div class='ad-searchbar' id='search-bar'>
            <form class='d-flex justify-content-center'>
                <input type='hidden' name='to' value='admin'>
                
                <input type='hidden' name='action' value='timkiem'>
                <input type='text' name='key' class='ad-search-box' placeholder='Tìm kiếm'>
                <button type='submit' class='search-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                        <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z' />
                    </svg>
                </button>
            </form>
        </div>        
        <div class='ad-header'>
            <h3 id='ad-tit'>Quản lý sản phẩm</h3>
            <a href='?to=admin&amp;action=addsp' class='ad-addbtn button'> + Thêm mới</a>
        </div>
        <div class='filter mb-3'>
        <form method='get'>
        <div class='form-floating '>
        <input type='hidden' name='to' value='admin'>
        <input type='hidden' name='action' value='locsanpham'>";
        $this->LoadDanhMuc('none');
            echo"
        </div>
    <button type='submit' class='filterbtn button'>Lọc</button>
    </form>
        </div>
        ";
        for ($i= 0; $i < count($sanPham) ; $i++) {
            $sanphaminfo = $sanPhamModel->LoadSanPhamInFo($sanPham[$i]["id_sanpham"]);
            if(isset($sanphaminfo[0]['giagiam'])){
                
                echo"<div class='row ad-product' id='qlysp'>

                <div class='col-md-3 col-lg-2 col-xl-2 col-2'>
                    <a href='./?to=detail&id=" . $sanPham[$i]["id_sanpham"] . "'>
                        <img class='img-fluid' src='". $sanPham[$i]["anhchinh"] . "'>
                    </a>
                </div>
        
                <div class='col-md-6 col-lg-8 col-xl-8 col-8 ad-proinfo'>
                    <h4>".$sanPham[$i]["ten"]."</h4>
                    <p>".$sanphaminfo[0]['tendanhmuc']."</p>
                    <span style='color:red'>".number_format($sanphaminfo[0]["giagiam"], 0, ',', ',')."₫</span>
                    <del>".number_format($sanPham[$i]["gia"],0,',',',') ."₫</del>
                </div>
                <div class='col-md-3 col-lg-2 col-xl-2 col-2 ad-action '>
                    <span class='sale-icon' onclick='toggleSaleForm($i)'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-tags' viewBox='0 0 16 16'>
                            <path d='M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z'/>
                            <path d='M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z'/>
                        </svg>
                    </span>
                    <a href='./?to=admin&amp;action=editsp&id_sanpham=".$sanPham[$i]["id_sanpham"]."' type='button' >
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z' />
                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z' />
                        </svg></a>
                    <a href='./?to=admin&amp;action=delproduct&id_sanpham=".$sanPham[$i]["id_sanpham"]."' type='button'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'></path>
                            <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'></path>
                        </svg>
                    </a>
                </div>
                <div class='col-12 saleform' >
                    <form  method='get' action='./'>
                    <input type='hidden' name='to' value='admin'>
                    <input type='hidden' name='action' value='sale'>
                    <input type='hidden' name='id' value='".$sanPham[$i]["id_sanpham"]."'>
                    <label for='sale'>Giá sẽ giảm của <strong>".$sanPham[$i]["ten"]." </strong>:</label>
                    <input type='number' id='sale' name='giagiam'>
                    <button type='submit' class='button adsalebtn' >Giảm Giá</button>
                    </form>
                <a href='./?to=admin&amp;action=xoagiamgia&id_sanpham=".$sanPham[$i]["id_sanpham"]."'>Xóa khuyến mãi</a>
                </div>
            </div>
           ";
            }else{
                echo"<div class='row ad-product' id='qlysp'>

                <div class='col-md-3 col-lg-2 col-xl-2 col-2'>
                    <a href='./?to=detail&id=" . $sanPham[$i]["id_sanpham"] . "'>
                        <img class='img-fluid' src='". $sanPham[$i]["anhchinh"] . "'>
                    </a>
                </div>
        
                <div class='col-md-6 col-lg-8 col-xl-8 col-8 ad-proinfo'>
                    <h4>".$sanPham[$i]["ten"]."</h4>
                    <p>".$sanphaminfo[0]['tendanhmuc']."</p>
                    <span>". number_format($sanPham[$i]["gia"],0,',',',') ."₫</span>
                    <del></del>
                </div>
                <div class='col-md-3 col-lg-2 col-xl-2 col-2 ad-action '>
                    <span class='sale-icon' onclick='toggleSaleForm($i)'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-tags' viewBox='0 0 16 16'>
                            <path d='M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z'/>
                            <path d='M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z'/>
                        </span>
                    </button>
                    <a href='./?to=admin&amp;action=editsp&id_sanpham=".$sanPham[$i]["id_sanpham"]."' type='button'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z' />
                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z' />
                        </svg></a>
                    <a href='./?to=admin&amp;action=delproduct&id_sanpham=".$sanPham[$i]["id_sanpham"]."' type='button'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'></path>
                            <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'></path>
                        </svg>
                    </a>
                </div>
                <div class='col-12 saleform' >
                    <form  method='get' action='./'>
                    <input type='hidden' name='to' value='admin'>
                    <input type='hidden' name='action' value='sale'>
                    <input type='hidden' name='id' value='".$sanPham[$i]["id_sanpham"]."'>
                    <label for='sale'>Giá sẽ giảm của <strong>".$sanPham[$i]["ten"]." </strong>:</label>
                    <input type='number' id='sale' name='giagiam'>
                    <button type='submit' class='button adsalebtn' >Giảm Giá</button>
                    </form>
                <a href='./?to=admin&amp;action=xoagiamgia&id_sanpham=".$sanPham[$i]["id_sanpham"]."'>Xóa khuyến mãi</a>
                </div>
            </div>
            <script src='public/scripts/admin.js'></script>
           ";

            }

        }
    }
}