/*function active(){
    document.getElementById("opLog").style.display="block";
}
function off(){
    document.getElementById("opLog").style.display="none";
}*/

let opLog = document.getElementById('opLog');
let login = document.getElementById('login');
let abrir = document.getElementById('abrir');
let off = document.getElementById('off');

let sign_in_btn = document.querySelector("#inicio");
let sign_up_btn = document.querySelector("#registro");
let contenedor = document.querySelector(".contenedor");
let sign_in_btn2 = document.querySelector("#inicio2");
let sign_up_btn2 = document.querySelector("#registro2");

let contenido = document.getElementById('cont');
let fnd = document.getElementById('fnd');
let cierre = document.getElementById('btnCerrar');

//abrir.addEventListener('click', () => opLog.style.display="block");
let cerrarVentana = () => {
    login.classList.add('close')
    setTimeout(() =>{
        login.classList.remove('close')
        opLog.style.display = 'none'
    }, 1);
}
//off.addEventListener('click',()=>cerrarVentana())
window.addEventListener('click', e=> e.target == opLog && cerrarVentana());

let cerrarVentanaModal = () => {
    contenido.classList.add('cierreMd')
    setTimeout(() =>{
        contenido.classList.remove('close')
        fnd.style.display = 'none'
        cierre.style.display= 'none'
    }, 1);
}
window.addEventListener('click', e=> e.target == fnd && cerrarVentanaModal())


/*sign_up_btn.addEventListener("click",()=>{
    contenedor.classList.add("registerMode");
});*/

/*sign_in_btn.addEventListener("click",()=>{
    contenedor.classList.remove("registerMode");
});*/


/*sign_up_btn2.addEventListener("click",()=>{
    contenedor.classList.add("registerMode2");
});*/

/*sign_in_btn2.addEventListener("click",()=>{
    contenedor.classList.remove("registerMode2");
});*/

/*window.onload = function(){
    let randomModal = Math.floor(Math.random() * (6 - 1 + 1)) + 1;
    if(randomModal == 1){
        document.getElementById("m1").style.display="block";
    }else if(randomModal == 2){
        document.getElementById("m2").style.display="block";
    }else if(randomModal == 3){
        document.getElementById("m3").style.display="block";
    }else if(randomModal == 4){
        document.getElementById("m4").style.display="block";
    }else if(randomModal == 5){
        document.getElementById("m5").style.display="block";
    }else if(randomModal == 6){
        document.getElementById("m6").style.display="block";
    }
}*/




