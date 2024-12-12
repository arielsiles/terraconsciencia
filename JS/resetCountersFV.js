function actualizarContadorFV() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './PHP/resetCountersFV.php');
    xhr.send();
    xhr.onload = function() {
        if (xhr.status != 200) {
            alert(`Error ${xhr.status}: ${xhr.statusText}`);
        } else {
            alert(xhr.response);
        }
    };
}