
var saleform = document.getElementsByClassName("saleform");
var salebtn = document.getElementsByClassName("sale-icon");

for (let i = 0 ; i < saleform.length; i++){
    saleform[i].style.display = "none";
}
function toggleSaleForm(n){
    if(saleform[n].style.display == "none"){
        saleform[n].style.display = "flex";
    }else
    {
        saleform[n].style.display = "none";
    }
}
