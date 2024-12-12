<?php
    include "conexionBe.php";
    $consulta = "SELECT id, opcV FROM test";
    $resultado = mysqli_query($conexion, $consulta);
    $respuestasCorrectas = array();
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $preguntaId = 'p' . $fila['id'];
        $respuestasCorrectas[$preguntaId] = $fila['opcV'];
    }
?>
function calcularResultado() {
  let formulario = document.getElementById('formulario');
  let respuestas = formulario.elements;

  let puntuacion = 0;

  <?php foreach ($respuestasCorrectas as $preguntaId => $respuestaCorrecta): ?>
    if (respuestas['<?php echo $preguntaId; ?>'].value === '<?php echo $respuestaCorrecta; ?>') {
      puntuacion++;
    }
  <?php endforeach; ?>
  let xhr = new XMLHttpRequest();
  xhr.open('POST', './PHP/actualizarPuntuacion.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function(){
    if (xhr.status === 200){
    }
  };
  xhr.send('puntuacion=' + puntuacion);
  let resultado = document.getElementById('resultado');
  let puntuacionTexto = document.getElementById('puntuacion');
  puntuacionTexto.textContent = 'Tu puntuación: ' + puntuacion + '/10';
  resultado.style.display = 'block';
}
