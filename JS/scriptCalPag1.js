function resultado() {
    var p1, p2, p3, p4, p5, p6;

    // 1a pregunta
    if (document.getElementById('p11').checked==true) {p1=180}
    else if (document.getElementById('p12').checked==true) {p1=420}
    else if (document.getElementById('p13').checked==true) {p1=660}
    else{p1=0}
    // 2a pregunta
    if (document.getElementById('p21').checked==true) {p2=225}
    else if (document.getElementById('p22').checked==true) {p2=525}
    else if (document.getElementById('p23').checked==true) {p2=825}
    else{p2=0}
    // 3a pregunta
    if (document.getElementById('p31').checked==true) {p3=600}
    else if (document.getElementById('p32').checked==true) {p3=1200}
    else if (document.getElementById('p33').checked==true) {p3=1800}
    else if (document.getElementById('p34').checked==true) {p3=2400}
    else{p3=0}
    // 4a pregunta
    if (document.getElementById('p41').checked==true) {p4=1200}
    else if (document.getElementById('p42').checked==true) {p4=2800}
    else if (document.getElementById('p43').checked==true) {p4=4400}
    else if (document.getElementById('p44').checked==true) {p4=0}
    else{p4=0}
    // 5a pregunta
    if (document.getElementById('p51').checked==true) {p5=24}
    else if (document.getElementById('p52').checked==true) {p5=56}
    else if (document.getElementById('p53').checked==true) {p5=88}
    else if (document.getElementById('p54').checked==true) {p5=0}
    else{p5=0}
    
    // 6a pregunta
    if (document.getElementById('p61').checked==true) {p6=630}
    else if (document.getElementById('p62').checked==true) {p6=1470}
    else if (document.getElementById('p63').checked==true) {p6=2310}
    else{p6=0}
    var resultado = document.getElementById('resultado');
    result = p1+p2+p3+p4+p5+p6;
    guardar_localstorage();
    resultado.innerHTML = p1+p2+p3+p4+p5+p6 + ' litros';
}
function guardar_localstorage(){
    var res = result;

    localStorage.setItem("res1" , res);
}