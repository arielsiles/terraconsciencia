document.getElementById("resetButton").addEventListener("click", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./PHP/resetPoints.php");
    xhr.onload = function() {
    if (xhr.status === 200) {
      alert(xhr.responseText);
    } else {
      alert("Hubo un error al intentar restablecer los puntos");
    }
    };
    xhr.send();
});
