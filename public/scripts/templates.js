var menuitems = document.getElementById('menuitems');
var searchbar = document.getElementById('search-bar');
var searchbtn = document.getElementById('searchbtn');
var closebar  = document.getElementById('close-bar');
var mybutton = document.getElementById("back-to-top");
var header = document.getElementById('header');

menuitems.style.maxHeight = "0px";
searchbar.style.visibility = "hidden";
header.style.position = "unset";
function menutoggle(){
	if(menuitems.style.maxHeight=="0px"){
		menuitems.style.maxHeight= "220px";
		
	header.style.opacity ='1000%'
	}else{
		menuitems.style.maxHeight = "0px";
		
	header.style.opacity ='70%'
	}
}
function showsearchbar(){
	if(searchbar.style.visibility == "hidden")
		searchbar.style.visibility = "visible";
		searchbar.style.right = "0";
		header.style.opacity ='100%'
}
function hidesearchbar(){
	searchbar.style.visibility = "hidden";
	searchbar.style.right = "-1500px";
	header.style.opacity ='70%'
}

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  	if(document.body.scrollTop > 150 || document.documentElement.scrollTop >150) {
    	mybutton.style.display = "block";
		header.style.opacity ="70%";
		header.style.transition = '0.5s';
		header.style.position = "fixed";
		header.style.backgroundColor = '#FFF';
		header.style.zIndex = '4';
		
  	}else{
		header.style.opacity ="100%";
		header.style.position = "unset";
    	mybutton.style.display = "none";
		header.style.backgroundColor = 'none';
		header.style.zIndex = '2';
		header.style.transition = '0s';
  	}	
  
}

function scrollToTop() {
  window.scrollTo(0, 0);
}