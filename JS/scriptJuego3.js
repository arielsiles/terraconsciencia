// Mostrar las preguntas ocultando el texto inicial
function mostrarPreguntas() {
  document.getElementById("actFVTxt").classList.add("d-none");
  document.getElementById("actFV").classList.remove("d-none");

  // Obtener preguntas dinámicamente desde el servidor
  fetch("./PHP/obtenerPreguntas.php")
      .then((response) => response.json())
      .then((data) => {
        const preguntasContainer = document.getElementById("preguntasContainer");
        preguntasContainer.innerHTML = ""; // Limpiar contenido previo

        data.forEach((pregunta, index) => {
          preguntasContainer.innerHTML += `
          <div class="mb-3">
            <h5>Afirmación ${index + 1} (+2pts.)</h5>
            <p>${pregunta.pregunta}</p>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="a${index + 1}" value="F" id="f${index + 1}">
              <label class="form-check-label" for="f${index + 1}">Falso</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="a${index + 1}" value="V" id="v${index + 1}">
              <label class="form-check-label" for="v${index + 1}">Verdadero</label>
            </div>
          </div>
        `;
        });
      })
      .catch((error) => console.error("Error al obtener las preguntas:", error));
}


// Volver al texto inicial
function volverTexto() {
  document.getElementById("actFV").classList.add("d-none");
  document.getElementById("actFVTxt").classList.remove("d-none");
}

// Calcular puntuación
function calcularPuntuacion() {
  fetch("./PHP/obtenerRespuestas.php")
      .then((response) => response.json())
      .then((respuestasCorrectas) => {
        const formulario = document.getElementById("formFV");
        let puntos = 0;

        for (let key in respuestasCorrectas) {
          const seleccion = formulario[key]?.value;
          if (seleccion === respuestasCorrectas[key]) {
            puntos += 2;
          }
        }

        // Mostrar resultado
        const resultado = document.getElementById("resultadoFV");
        const puntuacion = document.getElementById("puntuacionFV");

        puntuacion.textContent = `Tu puntuación: ${puntos}/10`;
        resultado.classList.remove("d-none");

        // Actualizar puntuación en el servidor
        actualizarPuntuacion(puntos);
      })
      .catch((error) => console.error("Error al obtener las respuestas:", error));
}

// Actualizar puntuación en el servidor
function actualizarPuntuacion(puntos) {
  fetch("./PHP/actualizarPuntuacionFV.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({ puntos }),
  })
      .then((response) => response.text())
      .then((data) => console.log(data))
      .catch((error) => console.error("Error al actualizar la puntuación:", error));
}