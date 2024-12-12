function resultado() {
    var p1, p2, p3, p4, p5, p6;

    // 1a pregunta
    if (document.getElementById('p11').checked==true) {p1=250}
    else if (document.getElementById('p12').checked==true) {p1=583,3333333}
    else if (document.getElementById('p13').checked==true) {p1=916,6666667}
    else if (document.getElementById('p14').checked==true) {p1=0}
    else{p1=0}
    // 2a pregunta
    if (document.getElementById('p21').checked==true) {p2=250}
    else if (document.getElementById('p22').checked==true) {p2=583,3333333}
    else if (document.getElementById('p23').checked==true) {p2=916,6666667}
    else if (document.getElementById('p24').checked==true) {p2=0}
    else{p2=0}
    // 3a pregunta
    if (document.getElementById('p31').checked==true) {p3=1350}
    else if (document.getElementById('p32').checked==true) {p3=3150}
    else if (document.getElementById('p33').checked==true) {p3=4950}
    else if (document.getElementById('p34').checked==true) {p3=0}
    else{p3=0}
    // 4a pregunta
    if (document.getElementById('p41').checked==true) {p4=1000}
    else if (document.getElementById('p42').checked==true) {p4=2333,333333}
    else if (document.getElementById('p43').checked==true) {p4=3666,666667}
    else if (document.getElementById('p44').checked==true) {p4=0}
    else{p4=0}
    // 5a pregunta
    if (document.getElementById('p51').checked==true) {p5=20,25}
    else if (document.getElementById('p52').checked==true) {p5=40,5}
    else if (document.getElementById('p53').checked==true) {p5=81}
    else if (document.getElementById('p54').checked==true) {p5=121,5}
    else if (document.getElementById('p55').checked==true) {p5=324}
    else if (document.getElementById('p56').checked==true) {p5=0}
    else{p5=0}
    
    // 6a pregunta
    if (document.getElementById('p61').checked==true) {p6=120}
    else if (document.getElementById('p62').checked==true) {p6=240}
    else if (document.getElementById('p63').checked==true) {p6=480}
    else if (document.getElementById('p64').checked==true) {p6=720}
    else if (document.getElementById('p65').checked==true) {p6=1920}
    else if (document.getElementById('p66').checked==true) {p6=0}
    else{p6=0}
    var resultado = document.getElementById('resultado');
    result = p1+p2+p3+p4+p5+p6;
    guardar_localstorage();
    resultado.innerHTML = p1+p2+p3+p4+p5+p6 + ' litros';

}

function guardar_localstorage(){
    var res = result;

    localStorage.setItem("res4" , res);
}