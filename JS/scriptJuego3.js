
/*Juego 3*/
function mostrarFV(){
  document.getElementById("actFV").style.zIndex="2";
  document.getElementById("vOp2").style.zIndex="2";
}
function ocultarFV(){
  document.getElementById("actFV").style.zIndex="0";
  document.getElementById("vOp2").style.zIndex="0";
}

function calcularPuntuacion() {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        try {
          let fov = JSON.parse(this.responseText);
          let formularioFV = document.getElementById('formFV');
          let respuestasFV = formularioFV.elements;

          let puntos = 0;

          if (respuestasFV['a1'].value === fov[2]) {
            puntos += 2;
          }

          if (respuestasFV['a2'].value === fov[3]) {
            puntos += 2;
          }

          if (respuestasFV['a3'].value === fov[4]) {
            puntos += 2;
          }

          if (respuestasFV['a4'].value === fov[5]) {
            puntos += 2;
          }

          if (respuestasFV['a5'].value === fov[6]) {
            puntos += 2;
          }

          let resultadoFV = document.getElementById('resultadoFV');
          let puntuacionFV = document.getElementById('puntuacionFV');
          puntuacionFV.textContent = 'Tu puntuación: ' + puntos + '/10';
          resultadoFV.style.display = 'block';

          let xhr2 = new XMLHttpRequest();
          xhr2.open("POST", "./PHP/actualizarPuntuacionFV.php");
          xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr2.send("puntos=" + puntos);
        } catch (error) {
          console.error("Error al parsear la respuesta del servidor: " + error);
        }
      } else {
        console.error("Error en la solicitud: " + this.status);
      }
    }
  };
  xhr.open("GET", "./PHP/obtenerFOV.php");
  xhr.send();
}
/*Fin Juego 3*/