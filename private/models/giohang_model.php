<?php
require_once("private/modules/db_module.php");
class GioHangModel
{
    public function LoadGioHang($id){

        $link = "";
        taoKetNoi($link);
        $result = chayTruyVanTraVeDL($link, "SELECT bangphu2.*, gg.giagiam 
                                            FROM (SELECT sp.*, bangphu1.id_taikhoan, bangphu1.size, bangphu1.soluong 
                                            FROM (SELECT * FROM tbl_giohang AS gh WHERE gh.id_taikhoan = $id) AS bangphu1 
                                            INNER JOIN tbl_sanpham AS sp ON bangphu1.id_sanpham = sp.id_sanpham) AS bangphu2 
                                            LEFT JOIN tbl_giamgia as gg on bangphu2.id_sanpham = gg.id_sanpham");

        $sanphams = array();
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($sanphams,$row);
        }
        return $sanphams;
    }

    public function XoaHangTrongGio($id_taikhoan, $id_sanpham, $size)
    {
        $link = "";
        taoKetNoi($link);
        $result = chayTruyVanKhongTraVeDL($link, "DELETE FROM tbl_giohang WHERE tbl_giohang.id_taikhoan = $id_taikhoan AND tbl_giohang.id_sanpham = $id_sanpham AND size = '$size'");
        return $result;
    }
    public function XoaGioHang($id_taikhoan){
        $link = "";
        taoKetNoi($link);
        $result = chayTruyVanKhongTraVeDL($link, "DELETE FROM tbl_giohang WHERE id_taikhoan= $id_taikhoan;");
    }

    public function ThemHang($id_taikhoan, $id_sanpham, $size, $soluong)
    {
        $link = "";
        taoKetNoi($link);
        $dem = 0;
        $result = chayTruyVanTraVeDL($link, "SELECT COUNT(id_taikhoan) FROM tbl_giohang WHERE `id_taikhoan` = $id_taikhoan AND `id_sanpham` = $id_sanpham AND `size` = '$size'");
        while ($row = mysqli_fetch_array($result)) {
            $dem  = $row[0];
        }
        if ($dem > 0) {
            // Đã tồn tại -> chỉ cập nhật
            chayTruyVanKhongTraVeDL($link, "UPDATE tbl_giohang SET `soluong` = `soluong` + $soluong WHERE `id_taikhoan` = $id_taikhoan AND `id_sanpham` = $id_sanpham AND `size` = '$size'");
        }
        else {
            // Chưa tồn tại -> thêm mới
            chayTruyVanKhongTraVeDL($link, "INSERT INTO tbl_giohang VALUES ($id_taikhoan,$id_sanpham,'$size',$soluong)");
        }
    }
    public function LoadSoLuongCuaSanPham($id_taikhoan, $id_sanpham,$size){
        $link = "";
        taoKetNoi($link);
        $result = chayTruyVanTraVeDL($link, "SELECT `soluong` FROM tbl_giohang WHERE `id_taikhoan` = $id_taikhoan AND `id_sanpham` = $id_sanpham AND `size` = '$size'");
        $soluong = mysqli_fetch_array($result);
        return $soluong;
    }
    public function CapNhatSoLuongCuaSanPham($idtaikhoan, $idsanpham,$size,$soluong){
        $link = "";
        taoKetNoi($link);
        chayTruyVanKhongTraVeDL($link, "UPDATE tbl_giohang SET `soluong` =  $soluong WHERE `id_taikhoan` = $idtaikhoan AND `id_sanpham` = $idsanpham AND `size` = '$size'");
    }


}
?>