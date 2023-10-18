<?php
require_once("private/modules/db_module.php");


class BannerModel
{
	
	public function LoadBanners($trang, $vitri){

		$link = "";				
		taoKetNoi($link);
		
		$result = chayTruyVanTraVeDL($link," SELECT * FROM tbl_banner AS banners WHERE banners.trang = '$trang' AND banners.vitri = '$vitri' ");
		
		
		$arrbanner = array();
		
		while($rows = mysqli_fetch_assoc($result)){
			
			array_push($arrbanner, $rows);
			
		}
		
		giaiPhongBoNho($link, $result);
		
		return($arrbanner);
	}
	public function LoadBanner($trang, $vitri){
		$banners = array();
        
		$link = "";
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link,"SELECT * FROM tbl_banner WHERE `trang` = '".$trang."' AND `vitri` = '".$vitri."'");
		while($rows = mysqli_fetch_assoc($result)){
			array_push($banners, $rows);
			break;
		}
		giaiPhongBoNho($link, $result);
		return $banners[0];
	}	
	public function LoadAllBanners(){
		$banners = array();
		$link = "";				
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link, "SELECT * FROM tbl_banner");

		while($rows = mysqli_fetch_assoc($result)){
			array_push($banners, $rows);
		}
		return $banners;
	}	
	public function AddBanner($ten,$diachianh,$mota,$trang,$vitri,$value){
		$link = "";
		taoKetNoi($link);
		chayTruyVanKhongTraVeDL($link, "INSERT INTO `tbl_banner` VALUES (NULL, '$ten', '$diachianh',
                                                                    '$mota', '$trang', '$value','$vitri', 'loai')"
                                                                    );	
	}
	public function XoaBanner($idbanner){
		$link = "";
		taoKetNoi($link);
		chayTruyVanKhongTraVeDL($link, "DELETE FROM tbl_banner WHERE tbl_banner.id_banner = $idbanner");
	}
	public function LoadBannerInfo($idbanner){
		$link = "";				
		taoKetNoi($link);
		$result = chayTruyVanTraVeDL($link, "SELECT * FROM tbl_banner WHERE id_banner = $idbanner");
		$banner = array();
		while($rows = mysqli_fetch_assoc($result)){
			array_push($banner, $rows);
		}
		return $banner;
	}
	public function CapNhatBanner($idbanner,$ten,$diachianh,$mota,$trang,$vitri,$value){
		$link = "";				
		taoKetNoi($link);
		chayTruyVanKhongTraVeDL($link, "UPDATE `tbl_banner` SET `ten` = '$ten', `diachianh`='$diachianh', `mota` = '$mota', `trang` = '$trang', `vitri`= '$vitri', `value` = '$value' WHERE id_banner = $idbanner" );
	}
	}
