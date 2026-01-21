function resultado() {
    var p1 = 0, p2 = 0, p3 = 0, p4 = 0, p5 = 0, p6 = 0;

    // 1a pregunta
    if (document.getElementById('p11')?.checked) p1 = 180;
    else if (document.getElementById('p12')?.checked) p1 = 420;
    else if (document.getElementById('p13')?.checked) p1 = 660;

    // 2a pregunta
    if (document.getElementById('p21')?.checked) p2 = 225;
    else if (document.getElementById('p22')?.checked) p2 = 525;
    else if (document.getElementById('p23')?.checked) p2 = 825;

    // 3a pregunta
    if (document.getElementById('p31')?.checked) p3 = 600;
    else if (document.getElementById('p32')?.checked) p3 = 1200;
    else if (document.getElementById('p33')?.checked) p3 = 1800;
    else if (document.getElementById('p34')?.checked) p3 = 2400;

    // 4a pregunta
    if (document.getElementById('p41')?.checked) p4 = 1200;
    else if (document.getElementById('p42')?.checked) p4 = 2800;
    else if (document.getElementById('p43')?.checked) p4 = 4400;
    else if (document.getElementById('p44')?.checked) p4 = 0;

    // 5a pregunta
    if (document.getElementById('p51')?.checked) p5 = 24;
    else if (document.getElementById('p52')?.checked) p5 = 56;
    else if (document.getElementById('p53')?.checked) p5 = 88;
    else if (document.getElementById('p54')?.checked) p5 = 0;

    // 6a pregunta
    if (document.getElementById('p61')?.checked) p6 = 630;
    else if (document.getElementById('p62')?.checked) p6 = 1470;
    else if (document.getElementById('p63')?.checked) p6 = 2310;

    // Sumar todos los valores
    var total = p1 + p2 + p3 + p4 + p5 + p6;

    // Mostrar resultado en la página
    document.getElementById('resultado').textContent = total + ' litros';

    // Guardar en LocalStorage
    guardar_localstorage(total);
}

function guardar_localstorage(total) {
    localStorage.setItem("res1", total);
}
