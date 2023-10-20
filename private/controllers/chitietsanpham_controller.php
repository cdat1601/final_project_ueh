<?php
require_once("private/models/sanpham_model.php");
class ChiTietSanPhamController{
    public function LoadChiTietSanPham(){
        $idsanpham = isset($_GET['id']) ? $_GET["id"] : -1 ;
        if($idsanpham != -1){
            $sanPhamModel = new SanPhamModel();
            $sanpham = $sanPhamModel->LoadSanPhamInFo($idsanpham);

            $giamgia = isset($sanpham[0]["giagiam"]) ? true : false ;
            
            if($giamgia){
                $this->LoadSanPhamSale($sanpham);
            }else{
                $this->LoadSanPham($sanpham);            
            }
        }
    }
    private function LoadSanPhamSale($sanpham){
        $id = $sanpham[0]["id_sanpham"];
        $ten = $sanpham[0]["ten"];
        $gia = $sanpham[0]["gia"];
        $danhmuc = $sanpham[0]["id_danhmuc"];
        $tendanhmuc = $sanpham[0]["tendanhmuc"];
        $giagiam = $sanpham[0]["giagiam"];
        $phantramgiam = round(100-($giagiam / $gia)*100);
        $anhchinh = $sanpham[0]["anhchinh"];
        $anhphu1 = $sanpham[0]["anhphu1"];
        $anhphu2 = $sanpham[0]["anhphu2"];
        $anhphu3 = $sanpham[0]["anhphu3"];
        $anhphu4 = $sanpham[0]["anhphu4"];
        $gioithieu  = $sanpham[0]["gioithieu"];
        $sizes = array();

        $ngat1 =strpos($gioithieu,'|');
  
        $ngat2 = strpos($gioithieu,'|',$ngat1+1);

        $mota1 = substr($gioithieu,  0, $ngat1);
        
        $mota2 = substr($gioithieu,$ngat1+1, $ngat2 - $ngat1-1);

        $mota3 = substr($gioithieu, $ngat2+1, strlen($gioithieu));

        foreach ($sanpham as $key => $value) {
            array_push($sizes, $value["size"]);
        }
       
        echo 
        "
            <header>
        ";
                 
        include_once("public/templates/header.php");                
        echo
        "
            </header>
        ";
        echo
        "
        <nav style='background-color:#F8F8F8' aria-label='breadcrumb'>
            <div class='container'>
                <ol class='breadcrumb'>
                    <li class='breadcrumb-item'><a href='./?to=home'>Trang chủ</a></li>
                    <li class='breadcrumb-item' aria-current='page'><a href='/?to=search&from=another&name=loai&value=$danhmuc'>$tendanhmuc</a></li>
                    <li class='breadcrumb-item active' aria-current='page'>$ten</li>
                </ol>
            </div>
        </nav>
        ";
        echo "<div class='container'>";

        echo "
        <div class='row'>
                <div class='col-lg-7 col-md-12 col-12'>
                    <div class='imgpro'>
                        <p class='img-icon'>
                        <img src='".$anhchinh."' alt='' class='small-img' onclick='set(0)'>
                        <img src='".$anhphu1."' alt='' class='small-img'onclick='set(1)'>
                        <img src='".$anhphu2."' alt='' class='small-img'onclick='set(2)'>
                        <img src='".$anhphu3."' alt='' class='small-img'onclick='set(3)'>
                        <img src='".$anhphu4."' alt='' class='small-img'onclick='set(4)'>
                        </p>
                        <div class='img-wrap'>
                        <img src='".$anhchinh."' alt='' id='ProductImg'>
                        </div>
                    </div>

                    <div class='introduction mt-3' id='desktop'>
                        <div class='col-12'>
                            <h3>Mô tả</h3>
                            <p>".$mota1." </p> 
                            <p> ".$mota2." </p>
                            <p> ".$mota3."</p>
                        </div>
                        <div class='col-12'>
                        ".$this->LoadSizeChart($danhmuc)."
                        </div>
                    </div>
                </div>

                <div class='col-lg-5 col-md-12 col-12' >
                <div class='buyform'>
                    <div class='pro-title'>
                        <h3>".$ten."</h3>
                    </div>
                    <div class='detail-pro-price'>
                        <span class='detail-pro-sale'>".$phantramgiam."%</span>
                        <span class='detail-pro-price'>".number_format($giagiam, 0, ',', ',')."₫</span>
                        <del>".number_format($gia, 0, ',', ',')."₫</del>
                    </div>

                    <form action='./' method='GET'>
                        <input type='hidden' name='to' value='cart'>
                        <input type='hidden' name='id_sanpham' value='".$id."'>
                        <input type='hidden' name='action' value='them'>";
                        if($danhmuc == 6){
                            echo " ";
                        }else {
                            echo"
                            <div class='size-select'>
                            ".$this->LoadSize($id,'XS')."
                            ".$this->LoadSize($id,'S')."
                            ".$this->LoadSize($id,'M')."
                            ".$this->LoadSize($id,'L')."
                            ".$this->LoadSize($id,'XL')."
                            </div>";
                        }
                        echo"
                        <div class='selector-actions'>
                            <div class='quantity' style='clear: both'>
                                <button type='button'  onclick='this.parentNode.querySelector(&quot;input[type=number]&quot;).stepDown()' class='minusdecrease'>-</button>
                                <input type='number' size='4' name='soluong' min='1' value='1' class='detail-number'>
                                <button type='button' onclick='this.parentNode.querySelector(&quot;input[type=number]&quot;).stepUp()'  class='plusincrease'>+</button>
                            </div>
                            <br style='clear: both'></br>
                            <div class='d-flex'>
                                <button type='submit' name='from' value='themvaogio' onclick='thongbao()' class='detail-btn add-btn'>Thêm vào giỏ</button>
                                <button type='submit' name='from' value='muangay' class='detail-btn buy-btn'>Mua ngay</button>
                            </div>
                        </div>
                    </form>


                    <div class='desc'>
                        <p><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-truck' viewBox='0 0 16 16'>
                                <path d='M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z' />
                            </svg> Giao hàng toàn quốc</p>
                        <p><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-hand-thumbs-up' viewBox='0 0 16 16'>
                                <path d='M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z' />
                            </svg> Cam kết chính hãng</p>
                        <p><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-patch-check' viewBox='0 0 16 16'>
                                <path fill-rule='evenodd' d='M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z' />
                                <path d='m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z' />
                            </svg> Bảo hành trọn đời</p>
                    </div>
                </div>

                </div>

                <div class='introduction mt-3' id='mobile'>
                        <div class='col-12'>
                            <h3>Mô tả</h3>
                            <p>".$mota1." </p> 
                            <p> ".$mota2." </p>
                            <p> ".$mota3."</p>
                        </div>
                        <div class='col-12'>
                            ".$this->LoadSizeChart($danhmuc)."
                        </div>
                    </div>
            </div>
            ";

        

        echo
        "
            <div class='row'>
                <div class='col'>
                    <div class='heading'>
                        <h2>Có thể bạn sẽ thích</h2>
                        <a class='more' href='./?to=search&from=another&name=loai&value=$danhmuc'>Xem thêm</a>
                    </div>
                </div>
            </div>
        ";

        echo "<div class='row pro-list'>";
        $this->LoadSanPhamLienQuan($danhmuc);  
        echo "</div>";
    echo"</div>";
    }
    private function LoadSanPham($sanpham){
        $id = $sanpham[0]["id_sanpham"];
        $ten = $sanpham[0]["ten"];
        $gia = $sanpham[0]["gia"];
        $danhmuc = $sanpham[0]["id_danhmuc"];
        $tendanhmuc = $sanpham[0]["tendanhmuc"];
        $anhchinh = $sanpham[0]["anhchinh"];
        $anhphu1 = $sanpham[0]["anhphu1"];
        $anhphu2 = $sanpham[0]["anhphu2"];
        $anhphu3 = $sanpham[0]["anhphu3"];
        $anhphu4 = $sanpham[0]["anhphu4"];
        $gioithieu  = $sanpham[0]["gioithieu"];


        $ngat1 =strpos($gioithieu,'|');

            $ngat2 = strpos($gioithieu,'|',$ngat1+1);
    
            $mota1 = substr($gioithieu,  0, $ngat1);
            
            $mota2 = substr($gioithieu,$ngat1+1, $ngat2 - $ngat1-1);
    
            $mota3 = substr($gioithieu, $ngat2+1, strlen($gioithieu));

                
        $sizes = array();
        foreach ($sanpham as $key => $value) {
            array_push($sizes, $value["size"]);
        }
       
            
        echo 
        "
            <header>
        ";
                 
        include_once("public/templates/header.php");                
        echo
        "
            </header>
        ";
        echo
        "
        <nav style='background-color:#F8F8F8' aria-label='breadcrumb'>
            <div class='container'>
                <ol class='breadcrumb'>
                    <li class='breadcrumb-item'><a href='./?to=home'>Trang chủ</a></li>
                    <li class='breadcrumb-item' aria-current='page'><a href='/?to=search&from=another&name=loai&value=$danhmuc'>$tendanhmuc</a></li>
                    <li class='breadcrumb-item active' aria-current='page'>$ten</li>
                </ol>
            </div>
        </nav>
        ";
        echo "<div class='container'>";

        echo "
        <div class='row'>
                <div class='col-lg-7 col-md-12 col-12'>
                    <div class='imgpro'>
                        <p class='img-icon'>
                        <img src='".$anhchinh."' alt='' class='small-img' onclick='set(0)'>
                        <img src='".$anhphu1."' alt='' class='small-img'onclick='set(1)'>
                        <img src='".$anhphu2."' alt='' class='small-img'onclick='set(2)'>
                        <img src='".$anhphu3."' alt='' class='small-img'onclick='set(3)'>
                        <img src='".$anhphu4."' alt='' class='small-img'onclick='set(4)'>
                        </p>
                        <div class='img-wrap'>
                        <img src='".$anhchinh."' alt='' id='ProductImg'>
                        </div>
                    </div>

                    <div class='introduction mt-4' id='desktop'>
                        <div class='col-12'>
                            <h3>Mô Tả</h3>
                            <p>".$mota1." </p> 
                            <p> ".$mota2." </p>
                            <p> ".$mota3."</p>
                        </div>
                        <div class='col-12'>
                        ".$this->LoadSizeChart($danhmuc)."
                        </div>
                    </div>
                </div>

                <div class='col-lg-5 col-md-12 col-12' >
                <div class='buyform'>
                    <div class='pro-title'>
                        <h3>".$ten."</h3>
                    </div>
                    <div class='detail-pro-price'>
                        <span class='detail-pro-price'>".number_format($gia, 0, ',', ',')."₫</span>
                    </div>

                    <form action='./' method='GET'>
                        <input type='hidden' name='to' value='cart'>
                        <input type='hidden' name='id_sanpham' value='".$id."'>
                        <input type='hidden' name='action' value='them'>
                        ";
                        if($danhmuc == 6){
                            echo " ";
                        }else {
                            echo"
                            <div class='size-select'>
                            ".$this->LoadSize($id,'XS')."
                            ".$this->LoadSize($id,'S')."
                            ".$this->LoadSize($id,'M')."
                            ".$this->LoadSize($id,'L')."
                            ".$this->LoadSize($id,'XL')."
                            </div>";
                        }
                        
                        echo"
                        <div class='selector-actions'>
                            <div class='quantity' style='clear: both'>
                                <button type='button' onclick='this.parentNode.querySelector(&quot;input[type=number]&quot;).stepDown()'  class='minusdecrease'>-</button>
                                <input type='number' size='4' name='soluong' min='1' value='1' class='detail-number'>
                                <button type='button' onclick='this.parentNode.querySelector(&quot;input[type=number]&quot;).stepUp()' class='plusincrease'>+</button>
                            </div>
                            <br style='clear: both'></br>
                            <div class='d-flex'>
                                <button type='submit' name='from' value='themvaogio' class='detail-btn add-btn'>Thêm vào giỏ</button>
                                <button type='submit' name='from' value='muangay' class='detail-btn buy-btn'>Mua ngay</button>
                            </div>
                            
                        </div>
                    </form>


                    <div class='desc'>
                        <p><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-truck' viewBox='0 0 16 16'>
                                <path d='M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z' />
                            </svg> Giao hàng toàn quốc</p>
                        <p><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-hand-thumbs-up' viewBox='0 0 16 16'>
                                <path d='M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z' />
                            </svg> Cam kết chính hãng</p>
                        <p><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-patch-check' viewBox='0 0 16 16'>
                                <path fill-rule='evenodd' d='M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z' />
                                <path d='m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z' />
                            </svg> Bảo hành trọn đời</p>
                    </div>
                </div>

                </div>

                <div class='introduction mt-3' id='mobile'>
                        <div class='col-12'>
                            <h3>Mô tả</h3>
                            <p>".$mota1." </p> 
                            <p> ".$mota2." </p>
                            <p> ".$mota3."</p>
                        </div>
                        <div class='col-12'>
                            ".$this->LoadSizeChart($danhmuc)."
                        </div>
                    </div>
            </div>
            ";

        

        echo
        "
            <div class='row'>
                <div class='col'>
                    <div class='heading'>
                        <h2>Có thể bạn sẽ thích</h2>
                        <a class='more' href='./?to=search&from=another&name=loai&value=$danhmuc'>Xem thêm</a>
                    </div>
                </div>
            </div>
        ";

        echo "<div class='row pro-list'>";
        $this->LoadSanPhamLienQuan($danhmuc);  
        echo "</div>";
    echo"</div>";
    }
    private function LoadSanPhamLienQuan($danhmuc){
        $sanPhamModel = new SanPhamModel();
        $sanpham = $sanPhamModel->LoadSanPhamTheoDanhMuc($danhmuc);
        for ($i = 0; $i < count($sanpham) && $i < 4; $i++) {
            // Trường hợp giày có thông tin giảm giá
            if (isset($sanpham[$i]["giagiam"])) {
                $phantramgiam = round(100-($sanpham[$i]["giagiam"]/$sanpham[$i]["gia"])*100);
                echo ("
                        <div class='col-lg-3 col-md-6 col-6 products'>
                            <div class='pro-img'>
                                <div class='pro-sale'><span>-" . $phantramgiam . "%</span></div>
                                <a href='./?to=detail&id=" . $sanpham[$i]["id_sanpham"] . "'>
                                    <img class='pro-img pro-img-1' src='" . $sanpham[$i]["anhphu1"] . "'>
                                    <img class='pro-img' src='" . $sanpham[$i]["anhchinh"] . "'>

                                </a>
                                <div class='pro-btn d-flex'>
                                    <a href='./?to=detail&id=".$sanpham[$i]["id_sanpham"]."' class='hidden-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                                    <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                                    <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                  </svg></a>
                                </div>
                            </div>
                            <div class='pro-detail'>
                                <h3 class='pro-name'><a href='./?to=detail&id=" . $sanpham[$i]["id_sanpham"] . "'>" . $sanpham[$i]["ten"] . "</a></h3>
                                <div class='pro-price'>
                                    <p class='pro-price sale'>" . number_format($sanpham[$i]["giagiam"], 0, ',', ',') . "đ 
                                        <span class='pro-price-retail'><del>" . number_format($sanpham[$i]["gia"], 0, ',', ',') . "₫</del></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                     ");
            }

            // Trường hợp giày không có thông tin giảm giá
            else {
                echo ("
                        <div class='col-lg-3 col-md-6 col-6 products'>
                            <div class='pro-img'>
                                
                                <a href='./?to=detail&id=" . $sanpham[$i]["id_sanpham"] . "'>
                                    <img class='pro-img pro-img-1' src='" . $sanpham[$i]["anhphu1"] . "'>
                                    <img class='pro-img' src='" . $sanpham[$i]["anhchinh"] . "'>

                                </a>
                                <div class='pro-btn d-flex'>
                                    <a href='./?to=detail&id=".$sanpham[$i]["id_sanpham"]."' class='hidden-btn'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                                    <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                                    <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                  </svg></a>
                                </div>
                            </div>
                            <div class='pro-detail'>
                                <h3 class='pro-name'><a href='./?to=detail&id=" . $sanpham[$i]["id_sanpham"] . "'>" . $sanpham[$i]["ten"] . "</a></h3>
                                <p class='pro-price'> 
                                    <span>".number_format($sanpham[$i]["gia"], 0, ',', ',')."₫</span>
                                </p>
                            </div>
                        </div>
                     ");
            }
        }

    }
    private function LoadSize($idsanpham,$size){
        $sanPhamModel = new SanPhamModel();
        $sanpham = $sanPhamModel->LoadSanPhamInFo($idsanpham);
        $tonkho = $sanPhamModel->LoadTonKho($idsanpham,$size);
        $sizes = array();
        foreach ($sanpham as $key => $value) {
            array_push($sizes, $value["size"]);
        }
        $hienthisize ='';
        if ($sanpham[0]['id_danhmuc'] == 6 ){
            $hienthisize .= "<p></p>";
        } else{
            if(in_array($size,$sizes) && $tonkho > 0){
                $hienthisize .= "<input type='radio' class='size-selector' name='size' id='$size' value='$size' autocomplete='off' checked=''>
                <label class='size-btn' for='$size'>$size</label>";
            }else {
                $hienthisize .= "<input type='radio' class='size-selector' name='size' id='$size' value='$size' autocomplete='off' disabled>
                <label class='size-btn' for='$size'>$size</label>";
            }
        }
        return $hienthisize;
    }
    private function LoadSizeChart($iddanhmuc){
        $hienthisizechart = '';
        if($iddanhmuc == 0 ){
            $hienthisizechart .= "<img src='public/images/others/sc5.jpg'>";
        }if($iddanhmuc == 2 ){
            $hienthisizechart .= "<img src='public/images/others/sc6.jpg'>";
        }if ($iddanhmuc == 1 ){
            $hienthisizechart .= "<img src='public/images/others/sc0.jpg'>";
        }if ($iddanhmuc == 3) {
            $hienthisizechart .= "<img src='public/images/others/sc2.webp'>";
        }if($iddanhmuc == 4 ){
            $hienthisizechart .= "<img src='public/images/others/sc3.webp'>";
        }if($iddanhmuc == 5 ){
            $hienthisizechart .= "<img src='public/images/others/sc4.webp'>";
        }

        return $hienthisizechart;
    }
}
