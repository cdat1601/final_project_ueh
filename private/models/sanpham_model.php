<?php
require_once("private/Modules/db_module.php");
class SanPhamModel{
    public function LoadAll(){
		$link = "";
		taoKetNoi($link);

		$result = chayTruyVanTraVeDL($link, "SELECT sanphams.* , giamgias.giagiam
											FROM( SELECT sanphams.* FROM tbl_sanpham as sanphams) AS sanphams LEFT JOIN tbl_giamgia AS giamgias
											ON sanphams.id_sanpham = giamgias.id_sanpham ORDER BY `sanphams`.`id_sanpham` ASC");
		$sanphams = array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($sanphams, $row);
		}
		return ($sanphams);
	}
	
	public function LoadSanPhamInFo($idsanpham){
		$link = null;
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link, "SELECT bangphu1.*, dm.tendanhmuc
											FROM (SELECT sp.*, dm.id_danhmuc 
											FROM (SELECT sp.*, s.size, s.tonkho
											FROM (SELECT sp.*, gg.giagiam
											FROM (SELECT * FROM tbl_sanpham AS sp WHERE sp.id_sanpham = $idsanpham) AS sp 
											LEFT JOIN tbl_giamgia AS gg ON sp.id_sanpham = gg.id_sanpham) AS sp 
											INNER JOIN tbl_size as s ON sp.id_sanpham = s.id_sanpham) AS sp
											INNER JOIN tbl_sanphamdm AS dm ON sp.id_sanpham = dm.id_sanpham) AS bangphu1 
											INNER JOIN tbl_danhmuc AS dm ON bangphu1.id_danhmuc = dm.id_danhmuc");
		$sanpham = array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($sanpham, $row);
		}
		return $sanpham;
	}

	public function LoadTonKho($idsanpham, $size){
		$link = null;
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link, "SELECT tbl_size.tonkho FROM tbl_size WHERE tbl_size.id_sanpham = $idsanpham and tbl_size.size = '$size';");
		while ($row = mysqli_fetch_array($result)) {
			return $row[0];
		}
	
	}

	public function LoadNewArrivals($ngay){

		$link = null;
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link, "SELECT sanphams.*, giamgias.giagiam 
											FROM (SELECT sanphams.* FROM tbl_sanpham as sanphams WHERE sanphams.ngaynhap >= $ngay) AS sanphams 
											LEFT JOIN tbl_giamgia AS giamgias 
											ON sanphams.id_sanpham = giamgias.id_sanpham  ORDER BY `sanphams`.`ngaynhap` DESC");

		$arrsp = array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($arrsp, $row);
		}
		giaiPhongBoNho($link, $result);

		return  $arrsp;
	}
	
	public function LoadHotSale(){
		$sanphams = array();
		$link = "";
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link, "SELECT * FROM tbl_giamgia as gg 
											LEFT JOIN tbl_sanpham as sp ON gg.id_sanpham = sp.id_sanpham WHERE (((100 - (gg.giagiam/sp.gia)*100)) > 0);");
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($sanphams, $row);
		}
		return $sanphams;
	}

	public function ThemSanPham($ten, $gia, $ngaynhap, $gioithieu, $anhchinh, $anh1, $anh2, $anh3, $anh4){
		$link = "";
		taoKetNoi($link);
		$result = chayTruyVanKhongTraVeDL($link, "INSERT INTO `tbl_sanpham` VALUES (NULL, '$ten', '$gia',
                                                                    '$ngaynhap', '$gioithieu', '$anhchinh', '$anh1', '$anh2','$anh3','$anh4')"
                                                                    );
		if($result == true){
			$idsanpham = chayTruyVanTraVeDL($link, "SELECT MAX(`id_sanpham`) FROM tbl_sanpham");
            while ($row = mysqli_fetch_array($idsanpham)) {
                return $row[0];
            }
        }
        else {
            return -1;
        }
	}

	public function LoadDanhMucSanPham(){
		$danhmuc = array();
		$link = "";
		taoKetNoi( $link );
		$result = chayTruyVanTraVeDL( $link, "SELECT * FROM `tbl_danhmuc` ORDER BY tendanhmuc ASC" );
		while ( $rows = mysqli_fetch_assoc( $result ) ) {
		  array_push( $danhmuc, $rows );
		}
		giaiPhongBoNho( $link, $result );
		return $danhmuc;
	}

	public function ThemDanhMucChoSanPham($idsanpham,$iddanhmuc){
		$link = "";
		taoKetNoi($link);
		chayTruyVanKhongTraVeDL($link, "INSERT INTO `tbl_sanphamdm` VALUES ($idsanpham, $iddanhmuc);");
		$result = chayTruyVanTraVeDL($link, "SELECT MAX(`id_sanpham`),id_danhmuc FROM tbl_sanphamdm;");
		while ($row = mysqli_fetch_array($result)) {
			return $row[1];
		}
	}

	public function ThemSizeChoSanPham($idsanpham,$size){
		$link = "";
		taoKetNoi($link);
		chayTruyVanKhongTraVeDL($link, "INSERT INTO `tbl_size` VALUES ($idsanpham, '$size',0);");
	}

	public function ThemTonKho($idsanpham,$size,$tonkho){
		$link = "";
		taoKetNoi($link);
		chayTruyVanKhongTraVeDL($link, "UPDATE tbl_size SET tonkho = $tonkho WHERE id_sanpham = $idsanpham and size = '$size'");
	}

	public function LoadSanPhamTheoTenHoacLoai($key)
	{
		$link = null;
		taoKetNoi($link);

		$result = chayTruyVanTraVeDL($link, "SELECT bangphu4.*, gg.giagiam FROM (SELECT * FROM (SELECT bangphu1.*, dm.tendanhmuc 
											FROM (SELECT sp.*, sp_dm.id_danhmuc FROM tbl_sanpham AS sp INNER JOIN tbl_sanphamdm AS sp_dm on sp.id_sanpham = sp_dm.id_sanpham) 
											AS bangphu1 INNER JOIN tbl_danhmuc as dm on bangphu1.id_danhmuc = dm.id_danhmuc) 
											AS bangphu3 WHERE bangphu3.ten LIKE '%".$key."%' OR bangphu3.tendanhmuc LIKE '%".$key."%')
											AS bangphu4 LEFT JOIN tbl_giamgia AS gg on bangphu4.id_sanpham = gg.id_sanpham;");
		$sanphams = array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($sanphams, $row);
		}
		return $sanphams;
	}
	public function LoadSanPhamTheoDanhMuc($iddanhmuc){
		
		$sanpham = array();
		$link = "";
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link, "SELECT bangphu1.*, gg.giagiam 
										FROM (SELECT sp.* FROM tbl_sanphamdm AS spdm 
										INNER JOIN tbl_sanpham as sp ON spdm.id_sanpham = sp.id_sanpham 
										WHERE spdm.id_danhmuc = " . $iddanhmuc . ") AS bangphu1 
										LEFT JOIN tbl_giamgia as gg ON bangphu1.id_sanpham = gg.id_sanpham");
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($sanpham, $row);
		}
		return $sanpham;
	}
	public function XoaSize($idsanpham)
	{
		$link = "";
		taoKetNoi($link);
		chayTruyVanKhongTraVeDL($link, "DELETE FROM tbl_size WHERE tbl_size.id_sanpham = $idsanpham");
	}
	public function CapNhatSanPhamInfo($idsanpham, $ten, $gia, $ngaynhap, $gioithieu, $anhchinh, $anh1, $anh2, $anh3, $anh4){
		$link = "";
		taoKetNoi($link);
		chayTruyVanKhongTraVeDL($link, "UPDATE `tbl_sanpham` SET `ten` = '$ten', `gia` = '$gia', `ngaynhap` = '$ngaynhap', `gioithieu` = '$gioithieu',`anhchinh` = '$anhchinh', `anhphu1` = '$anh1', `anhphu2` = '$anh2',`anhphu3` = '$anh3',`anhphu4` = '$anh4'  WHERE `id_sanpham` = $idsanpham");
           
	}
	public function CapNhatDanhMuc($idsanpham,$iddanhmuc){
		$link = "";
		taoKetNoi($link);
		chayTruyVanKhongTraVeDL($link, "UPDATE `tbl_sanphamdm` SET `id_danhmuc` = $iddanhmuc WHERE id_sanpham=$idsanpham ");
      
	}
	public function XoaSanPham($idsanpham){
		$link = "";
		taoKetNoi($link);
		
		chayTruyVanKhongTraVeDL($link, "DELETE FROM tbl_sanphamdm WHERE tbl_sanphamdm.id_sanpham = $idsanpham ");
		chayTruyVanKhongTraVeDL($link, "DELETE FROM tbl_sanpham WHERE tbl_sanpham.id_sanpham = $idsanpham ");
		chayTruyVanKhongTraVeDL($link, "DELETE FROM tbl_size WHERE tbl_size.id_sanpham = $idsanpham ");
	}
	public function CapNhatGiamGia($idsanpham, $giagiam){
		$link = "";
		taoKetNoi($link);

		$giamgia = chayTruyVanTraVeDL($link, "SELECT COUNT(`id_sanpham`) FROM tbl_giamgia where `id_sanpham` = '$idsanpham';");
        $dem = 0;
        while ($row = mysqli_fetch_array($giamgia)) {
           $dem = $row[0];
        }
        if ($dem == 0) {
            chayTruyVanKhongTraVeDL($link, "INSERT INTO `tbl_giamgia` VALUES ($idsanpham,$giagiam)");
        }else{
			chayTruyVanKhongTraVeDL($link, "UPDATE tbl_giamgia SET `giagiam`= '$giagiam' WHERE `id_sanpham` = $idsanpham");
		}
	}
	public function XoaGiamGia($idsanpham){
		$link = "";
		taoKetNoi($link);
		chayTruyVanKhongTraVeDL($link, "DELETE FROM tbl_giamgia WHERE id_sanpham = $idsanpham ");
	}
	public function LoadSanPhamTheoFilter($danhmuc, $gia, $size)
	{

		$query = "SELECT DISTINCT(`id_sanpham`), bangphu2.ten, bangphu2.gia, bangphu2.anhchinh, bangphu2.anhphu1, bangphu2.giagiam FROM (SELECT bangphu1.*, tbl_giamgia.giagiam FROM (SELECT bangphu.*, tbl_size.size FROM (SELECT tbl_sanpham.*, tbl_sanphamdm.id_danhmuc FROM tbl_sanpham INNER JOIN tbl_sanphamdm ON tbl_sanpham.id_sanpham = tbl_sanphamdm.id_sanpham) AS bangphu INNER JOIN tbl_size ON bangphu.id_sanpham = tbl_size.id_sanpham) AS bangphu1 LEFT JOIN tbl_giamgia ON bangphu1.id_sanpham = tbl_giamgia.id_sanpham) AS bangphu2";

		if ($danhmuc != -1 || $gia != -1 || $size != -1) {
			$query .= " WHERE ";

			if ($danhmuc != -1) {
				$query .= " ( ";
				for ($i = 0; $i < count($danhmuc); $i++) {

					if ($i == 0) {
						$query .= " bangphu2.id_danhmuc = " . $danhmuc[$i] . " ";
					} else {
						$query .= " OR bangphu2.id_danhmuc = " . $danhmuc[$i] . " ";
					}
				}
				$query .= " ) ";
			}

			if ($gia != -1) {

				for ($i = 0; $i < count($gia); $i++) {
					if ($i == 0 && $danhmuc != -1) {
						$query .= " And (IFNULL(bangphu2.giagiam,bangphu2.gia)" . $gia[$i] . " ";
					} else {
						if ($i == 0 && !$danhmuc != -1) {
							$query .= " (IFNULL(bangphu2.giagiam,bangphu2.gia)" . $gia[$i] . " ";
						} else {
							$query .= " OR IFNULL(bangphu2.giagiam,bangphu2.gia)" . $gia[$i] . " ";
						}
					}
				}
				$query .= " ) ";
			}

			if ($size != -1) {
				for ($i = 0; $i < count($size); $i++) {

					if ($i == 0 && $gia != -1 || $danhmuc != -1) {
						$query .= " And ( bangphu2.size = '" . $size[$i] . "'";
					} else {
						if ($i == 0 && !($gia != -1) || $danhmuc != -1) {
							$query .= " ( bangphu2.size = '" . $size[$i] . "'";
						} else {
							$query .= " OR bangphu2.size = '" . $size[$i] . "'";
						}
					}
					
				}
				$query .= " ) ";
			}
		}

		

		$sanphams = array();
		$link = "";
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($sanphams, $row);
		}
		
		return $sanphams;
	}

}
