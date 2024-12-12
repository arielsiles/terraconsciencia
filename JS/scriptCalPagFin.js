function cal_res(){
    res1 + res2 + res3 + res4;
    res1 = localStorage.getItem("res1");
    res2 = localStorage.getItem("res2");
    res3 = localStorage.getItem("res3");
    res4 = localStorage.getItem("res4");
    let respuesta = res1 + res2 + res3 + res4;
    let numeroLimitado = respuesta.toFixed(2);
    numeroLimitado = parseFloat(numeroLimitado);
    resp_total.innerHTML = numeroLimitado + ' litros';
}