function resultado() {
    var p1, p2, p3, p4, p5, p6, p7, p8, p9, p10;

    // 1a pregunta
    if (document.getElementById('p11').checked==true) {p1=96}
    else if (document.getElementById('p12').checked==true) {p1=224}
    else if (document.getElementById('p13').checked==true) {p1=352}
    else if (document.getElementById('p14').checked==true) {p1=0}
    else{p1=0}
    // 2a pregunta
    if (document.getElementById('p21').checked==true) {p2=450}
    else if (document.getElementById('p22').checked==true) {p2=1050}
    else if (document.getElementById('p23').checked==true) {p2=1650}
    else if (document.getElementById('p24').checked==true) {p2=0}
    else{p2=0}
    // 3a pregunta
    if (document.getElementById('p31').checked==true) {p3=450}
    else if (document.getElementById('p32').checked==true) {p3=1050}
    else if (document.getElementById('p33').checked==true) {p3=1650}
    else if (document.getElementById('p34').checked==true) {p3=0}
    else{p3=0}
    // 4a pregunta
    if (document.getElementById('p41').checked==true) {p4=450}
    else if (document.getElementById('p42').checked==true) {p4=1050}
    else if (document.getElementById('p43').checked==true) {p4=1650}
    else if (document.getElementById('p44').checked==true) {p4=0}
    else{p4=0}
    // 5a pregunta
    if (document.getElementById('p51').checked==true) {p5=1282,5}
    else if (document.getElementById('p52').checked==true) {p5=2992,5}
    else if (document.getElementById('p53').checked==true) {p5=4702,5}
    else if (document.getElementById('p54').checked==true) {p5=0}
    else{p5=0}
    
    // 6a pregunta
    if (document.getElementById('p61').checked==true) {p6=7680}
    else if (document.getElementById('p62').checked==true) {p6=17920}
    else if (document.getElementById('p63').checked==true) {p6=28160}
    else if (document.getElementById('p64').checked==true) {p6=0}
    else{p6=0}

    // 7a pregunta
    if (document.getElementById('p71').checked==true) {p7=3840}
    else if (document.getElementById('p72').checked==true) {p7=8960}
    else if (document.getElementById('p73').checked==true) {p7=14080}
    else if (document.getElementById('p74').checked==true) {p7=0}
    else{p7=0}
    // 8a pregunta
    if (document.getElementById('p81').checked==true) {p8=5760}
    else if (document.getElementById('p82').checked==true) {p8=13440}
    else if (document.getElementById('p83').checked==true) {p8=21120}
    else if (document.getElementById('p84').checked==true) {p8=0}
    else{p8=0}
    // 9a pregunta
    if (document.getElementById('p91').checked==true) {p9=2266.67}
    else if (document.getElementById('p92').checked==true) {p9=0}
    else{p9=0}
    // 10a pregunta
    if (document.getElementById('p101').checked==true) {p10=200}
    else if (document.getElementById('p102').checked==true) {p10=400}
    else if (document.getElementById('p103').checked==true) {p10=800}
    else if (document.getElementById('p104').checked==true) {p10=1600}
    else if (document.getElementById('p105').checked==true) {p10=0}
    else{p10=0}
    var resultado = document.getElementById('resultado');
    result = p1+p2+p3+p4+p5+p6+p7+p8+p9+p10;
    guardar_localstorage();
    resultado.innerHTML = p1+p2+p3+p4+p5+p6+p7+p8+p9+p10 + ' litros';
}
function guardar_localstorage(){
    var res = result;

    localStorage.setItem("res2" , res);
}