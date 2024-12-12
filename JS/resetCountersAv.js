function resetCountersAv() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./PHP/resetCountersAv.php");
    xhr.onload = function() {
        if (xhr.status === 200) {
        alert(xhr.responseText);
        } else {
        alert("Hubo un error al intentar restablecer los contadores");
        }
    };
    xhr.send();
}