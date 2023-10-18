<?php
require_once("private/models/giohang_model.php");
require_once("private/modules/db_module.php");
class HoaDonModel{
   public function ThemHoaDon($idtaikhoan, $idkhachhang ,$hoten, $email, $sdt, $diachi , $hinhthucvanchuyen, $hinhthucthanhtoan,$chiphivanchuyen){
        $gioHangModel = new GioHangModel();
        $sanpham = $gioHangModel->LoadGioHang($idtaikhoan);

        $tamtinh = 0;
        $giamgia = 0;
        foreach ($sanpham as $key => $value) {
            $tamtinh += $value["gia"] * $value["soluong"];
            $giamgia += (isset($value["giagiam"]) ? $value['gia']-$value["giagiam"] : 0) * $value["soluong"];
        }
        $tongtien = $tamtinh + 50000 - $giamgia;

        $link = "";
        taoKetNoi($link);
        //Them hoa don
        $result = chayTruyVanKhongTraVeDL($link, "INSERT INTO `tbl_hoadon` (`id_hoadon`, `id_khachhang`, `hoten`, `email`, `sodienthoai`, `diachi`, `hinhthucvanchuyen`, `hinhthucthanhtoan`, `tamtinh`, `phivanchuyen`, `giamgia`, `ngaylap`, `tongtien` , `trangthai`) 
                                                                            VALUES (NULL, '$idkhachhang', '$hoten', '$email', '$sdt', '$diachi', '$hinhthucvanchuyen', '$hinhthucthanhtoan', '$tamtinh', '$chiphivanchuyen', '$giamgia', CURRENT_DATE(), '$tongtien', 'Chờ xác nhận' );");
        if ($result == false) {
            return false;
        }
        else {
            //Lay idhoadon
            $idhoadon = "";
            $result2 = chayTruyVanTraVeDL($link, "SELECT MAX(`id_hoadon`) FROM tbl_hoadon");
            while ($row = mysqli_fetch_array($result2)) {
                $idhoadon = $row[0];
                break;
            }
            // Thêm chi tiết hóa đơn
            foreach ($sanpham as $key => $value) {
                $giasp = isset($value['giagiam']) ? $value['giagiam'] : $value['gia'];
                $thanhtien = $giasp * $value["soluong"];
                chayTruyVanKhongTraVeDL($link, "INSERT INTO `tbl_chitiethoadon` VALUES ('$idhoadon', '".$value["id_sanpham"]."', '".$value["size"]."' ,'".$value["soluong"]."', '$thanhtien');");
            }
            return true;
        }                                                                    
    }
    public function LoadThongTinThanhToan(){
        $link = "";
        taoKetNoi($link);
        $hoadon = array();
        $id = chayTruyVanTraVeDL($link, "SELECT MAX(`id_hoadon`) FROM tbl_hoadon");
        while ($row = mysqli_fetch_array($id)) {
            $idhoadon = $row[0];
            break;
        }
        $result = chayTruyVanTraVeDL($link, "SELECT * FROM tbl_hoadon as hd
                                            INNER JOIN tbl_chitiethoadon as cthd ON hd.id_hoadon = cthd.id_hoadon WHERE hd.id_hoadon = $idhoadon;");
        while ($row = mysqli_fetch_assoc($result)) {
			array_push($hoadon, $row);
		}
		return $hoadon;                                    
    }
    public function LoadHoaDonCuaTaiKhoan($idtaikhoan){
        $link = "";
        taoKetNoi($link);
        $hoadon = array();
        $result = chayTruyVanTraVeDL($link,"SELECT * FROM `tbl_hoadon` WHERE `id_khachhang` = $idtaikhoan");
        while ($row = mysqli_fetch_assoc($result)) {
			array_push($hoadon, $row);
		}
        return $hoadon;
    }
    public function LoadChiTietHoaDon($idhoadon){
        $link = "";
        taoKetNoi($link);
        $sanpham = array();
        $result = chayTruyVanTraVeDL($link, "SELECT sp.ten, sp.anhchinh, cthd.* 
                                            FROM  (SELECT * FROM  tbl_chitiethoadon AS cthd WHERE cthd.id_hoadon = $idhoadon) AS cthd 
                                            JOIN tbl_sanpham AS sp ON sp.id_sanpham = cthd.id_sanpham;");
        while ($row = mysqli_fetch_assoc($result)) {
        array_push($sanpham, $row);
    }
    return $sanpham;
    }
    public function LoadThongTinHoaDon($idhoadon){
        $link = "";
        taoKetNoi($link); 
        $hoadon = array();
        $result = chayTruyVanTraVeDL($link,"SELECT * FROM `tbl_hoadon` WHERE `id_hoadon` = $idhoadon");
        while ($row = mysqli_fetch_assoc($result)) {
			array_push($hoadon, $row);
		}
        return $hoadon;
    }
    public function LoadAll(){
        $link = "";
		taoKetNoi($link);

		$result = chayTruyVanTraVeDL($link, "SELECT * FROM `tbl_hoadon` as hd ORDER BY hd.`id_hoadon` ASC");
		$hoadons = array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($hoadons, $row);
		}
		return ($hoadons);
   }
   public function CapNhatTrangThai($idhoadon,$status){
        $link = "";
        taoKetNoi($link);
        $result = chayTruyVanKhongTraVeDL($link, "UPDATE tbl_hoadon AS hd SET hd.trangthai = '$status' WHERE hd.id_hoadon = '$idhoadon'");
        return $result;
   }
   public function LoadHoaDonTheoTrangThai($trangthai){
    $link = "";
    taoKetNoi($link);

    $result = chayTruyVanTraVeDL($link, "SELECT * FROM `tbl_hoadon` as hd WHERE hd.`trangthai` = '$trangthai' ORDER BY hd.`id_hoadon` ASC");
    $hoadons = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($hoadons, $row);
    }
    return ($hoadons);
   }
   public function LoadHoaDonTheoSDT($sdt){
    $link = "";
    taoKetNoi($link);

    $result = chayTruyVanTraVeDL($link, "SELECT * FROM `tbl_hoadon` as hd WHERE hd.`sodienthoai` = '$sdt' ORDER BY hd.`id_hoadon` ASC");
    $hoadons = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($hoadons, $row);
    }
    return ($hoadons);
   }
}
?>