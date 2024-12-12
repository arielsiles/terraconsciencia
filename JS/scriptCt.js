let contenido = document.getElementById('cont');
let fnd = document.getElementById('fnd');
let cierre = document.getElementById('btnCerrar');

let radioInputs = document.querySelectorAll('input[name="opc"]');
let labels = document.querySelectorAll('label');

let cerrarVentanaModal = () => {
    contenido.classList.add('cierreMd')
    setTimeout(() =>{
        contenido.classList.remove('close')
        fnd.style.display = 'none'
        cierre.style.display= 'none'
    }, 1);
}
window.addEventListener('click', e=> e.target == fnd && cerrarVentanaModal());

function abreCt(){
    document.getElementById("despCt").style.display="block";
    document.getElementById('giro').style.transform="rotate(180deg)";
    document.getElementById('cl').style.zIndex=0;
}
function cierraCt(){
    document.getElementById("despCt").style.display="none";
    document.getElementById('giro').style.transform="rotate(0deg)";
    document.getElementById('cl').style.zIndex=-1;
}

for (let i = 0; i < radioInputs.length; i++) {
  radioInputs[i].addEventListener("change", function() {
    let selectedLabel = document.querySelector('label[for="' + this.id + '"]');
    labels.forEach(function(label) {
      label.classList.remove("checked-label");
    });
    selectedLabel.classList.add("checked-label");
  });
}
function abreConf(){
    document.getElementById('fndCf').style.display="block";
}
function cierraConf(){
    document.getElementById('fndCf').style.display="none";
}

