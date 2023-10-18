var filterbranditems = document.getElementById('filter-brand-items');
var filterpriceitems = document.getElementById('filter-price-items');
var filtersizeitems = document.getElementById('filter-size-items');
var filtercontrol = document.getElementsByClassName("filter-control");
var filter = document.getElementById('filter');

filterbranditems.style.display = "block";
filterpriceitems.style.display = "block";
filtersizeitems.style.display = "block";

function filtertoogle(el){
	if(filter.style.display == "none"){
		filter.style.display = "block";
		el.innerHTML = "Bộ lọc sản phẩm ▲";
	}else{
		filter.style.display = "none";
		el.innerHTML = "Bộ lọc sản phẩm ▼"
	}
}
function filterbrandtoggle(el){
	if(filterbranditems.style.display == "block"){
		filterbranditems.style.display = "none";
		el.innerHTML = "+";
		filtercontrol.innerHTML = "+";
	}else{
		filterbranditems.style.display = "block";
		el.innerHTML = "-";
	}
}
function filterpricetoggle(el){
	if(filterpriceitems.style.display == "none"){
		filterpriceitems.style.display = "block";
		el.innerHTML = "-";
		filtercontrol.innerHTML = "-";
	}else{
		filterpriceitems.style.display = "none";
		el.innerHTML = "+";
	}
}
function filtersizetoggle(el){
	if(filtersizeitems.style.display == "none"){
		filtersizeitems.style.display = "block";
		el.innerHTML = "-";
		filtercontrol.innerHTML = "-";
	}else{
		filtersizeitems.style.display = "none";
		el.innerHTML = "+";
	}
}