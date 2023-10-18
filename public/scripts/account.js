var button1 = document.getElementById("mot");
var button2 = document.getElementById("hai");
var form1 = document.getElementById("form1");
var form2 = document.getElementById("form2");
var notice = document.getElementsByClassName("alert");

form1.style.display = "block";
form2.style.display = "none";
button2.style.backgroundColor = "#FFFFFF";
button2.style.color = "#000000";

button2.style.borderBottom = "1px solid"

button1.addEventListener("click", showform1);
button2.addEventListener("click", showform2, false);

function showform1(){
    form1.style.display = "block";
    form2.style.display = "none";
    button1.style.backgroundColor = "#000000";
    button1.style.color = "#FFFFFF";
    button2.style.backgroundColor = "#FFFFFF";
    button2.style.color = "#000000";  
    button2.style.borderBottom = "1px solid"
}
function showform2() {
    if(form2.style.display == "none"){
        form2.style.display = "block";
        form1.style.display = "none";
        button2.style.backgroundColor = "#000000";
        button2.style.color = "#FFFFFF";
        button1.style.backgroundColor = "#FFFFFF";
        button1.style.color = "#000000";
        button1.style.borderBottom = "1px solid" 
    }else{
        button2.style.backgroundColor = "#000000";
        button2.style.color = "#FFFFFF";
        button1.style.backgroundColor = "#FFFFFF";
        button1.style.color = "#000000";
        
    }
    
}

setTimeout(function hidden(){
    notice[0].setAttribute('style' , 'display: none');
}, 3500);