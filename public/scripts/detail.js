
var ProductImg = document.getElementById("ProductImg");
var SmallImg = document.getElementsByClassName("small-img");
//buyForm.style.position = "unset";
function set(i) {
    ProductImg.src = SmallImg[i].src;
}
