<?php
class SwichPageControler
{
    public function SwitchPage()
    {
        $to = isset($_GET['to']) ? $_GET['to'] : -1;
        if ($to == -1) {
            $to = isset($_POST['to']) ? $_POST['to'] : -1;
        }
        if ($to != -1) {
            
            switch ($to) {
                case 'detail':
                    
                    include_once("public/views/chitietsanpham.php");
                    break;
                case 'cart':
                    include_once("public/views/giohang.php");
                    break;
                case 'search':
                    include_once("public/views/hienthitimkiem.php");
                    break;
                case 'login':
                    include_once("public/views/dangnhap.php");
                    break;
                case 'signup':
                    include_once("public/views/dangky.php");
                    break;
                case 'rspw':
                    include_once("public/views/resetpassword.php");
                    break;
				case 'addbn':
					include_once("public/views/addbanner.php");
					break;
				case 'giayAD':
					include_once("public/views/thaotacSP.php");
					break;
                case 'purchase':
                    include_once("public/views/dathang.php");
                    break;
                case 'account':
                    include_once("public/views/taikhoan.php");
                    break;
                case 'orderresult':
                    include_once("public/views/ketquadathang.php");
                    break;
                case 'admin':
                        include_once("public/views/qlysanpham.php");
                        break;
                case'banner':
                        include_once("public/views/qlybanner.php");
                        break;
                case'donhang':
                        include_once("public/views/qlydonhang.php");
                        break;
                    
                default:
                    include_once("public/views/trangchu.php");
                    break;
            }
        } else {
            include_once("public/views/trangchu.php");
        }
    }
}
