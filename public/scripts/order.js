
var chiPhiVanChuyenUI1 = document.getElementById("chiphivanchuyen_ui1");
var chiPhiVanChuyenUI2 = document.getElementById("chiphivanchuyen_ui2");
var tongcong1 = document.getElementById("tongcong1");
var tongcong2 = document.getElementById("tongcong2");
var hinhthucvanchuyen1 = document.getElementById("giaohangtieuchuan");
var hinhthucvanchuyen2 = document.getElementById("giaohangnhanh");
var giamgia1 = document.getElementById("giamgia1");
var giamgia2 = document.getElementById("giamgia2");
var tamtinh1 = document.getElementById("tamtinh1");
var tamtinh2 = document.getElementById("tamtinh2");

hinhthucvanchuyen1.addEventListener("click", GiaoHangOnClick, false);
hinhthucvanchuyen2.addEventListener("click", GiaoHangOnClick, false);


function GiaoHangOnClick(){
    if (this.value == "tieuchuan") {
        chiPhiVanChuyenUI1.innerHTML = "25,000đ";
        chiPhiVanChuyenUI2.innerHTML = "25,000đ";
        chiPhiVanChuyenUI1.setAttribute("value", "25000");
        chiPhiVanChuyenUI2.setAttribute("value", "25000");

        tongcong1.innerHTML = formatNumber(parseFloat(tamtinh1.getAttribute("value")) + parseFloat(chiPhiVanChuyenUI1.getAttribute("value")) - parseFloat(giamgia1.getAttribute("value")))+"₫";
        tongcong2.innerHTML = formatNumber(parseFloat(tamtinh2.getAttribute("value")) + parseFloat(chiPhiVanChuyenUI2.getAttribute("value")) - parseFloat(giamgia2.getAttribute("value")))+"₫";
    }
    else{
        chiPhiVanChuyenUI1.innerHTML = "50,000đ";
        chiPhiVanChuyenUI2.innerHTML = "50,000đ";
        chiPhiVanChuyenUI1.setAttribute("value", "50000");
        chiPhiVanChuyenUI2.setAttribute("value", "50000");

        tongcong1.innerHTML = formatNumber(parseFloat(tamtinh1.getAttribute("value")) + parseFloat(chiPhiVanChuyenUI1.getAttribute("value")) - parseFloat(giamgia1.getAttribute("value")))+"₫";
        tongcong2.innerHTML = formatNumber(parseFloat(tamtinh2.getAttribute("value")) + parseFloat(chiPhiVanChuyenUI2.getAttribute("value")) - parseFloat(giamgia2.getAttribute("value")))+"₫";
    }    
    function formatNumber(num){
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }
}

