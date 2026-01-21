/*Juego 1*/

let cartasVolteadas = 0;
let carta1, carta2;

function voltearCarta(event) {
  let carta = event.currentTarget;
  if (carta.classList.contains("volteada") || cartasVolteadas === 2) {
    return;
  }
  carta.classList.add("volteada");

  if (cartasVolteadas === 0) {
    carta1 = carta;
    cartasVolteadas = 1;
  } else if (cartasVolteadas === 1) {
    carta2 = carta;
    cartasVolteadas = 2;

    // Verificamos si las cartas coinciden
    if (carta1.querySelector(".back img").src === carta2.querySelector(".back img").src) {
      // No ocultamos las cartas, solo dejamos las cartas volteadas
      setTimeout(function() {
        // Ahora solo limpiamos las variables para las cartas
        carta1 = null;
        carta2 = null;
        cartasVolteadas = 0;
        // Verificar el fin del juego después de que ambas cartas hayan sido volteadas
        verificarFinJuego();
      }, 500); // Esperar medio segundo para asegurar que ambas cartas se hayan volteado
    } else {
      setTimeout(function() {
        carta1.classList.remove("volteada");
        carta2.classList.remove("volteada");
        carta1 = null;
        carta2 = null;
        cartasVolteadas = 0;
        // Verificar el fin del juego después de la animación de las cartas
        verificarFinJuego();
      }, 500); // Esperar medio segundo para asegurar que ambas cartas se hayan volteado
    }
  }
}


function verificarFinJuego() {
  let cartas = document.getElementsByClassName("carta");

  // Verificamos si todas las cartas están volteadas
  for (let i = 0; i < cartas.length; i++) {
    if (!cartas[i].classList.contains("volteada")) {
      return; // Si alguna carta no está volteada, no termina el juego
    }
  }

  // Si todas las cartas están volteadas (y por ende emparejadas)
  alert("¡Has ganado! ¡Has encontrado todas las cartas!");

  // Asignamos la puntuación al usuario
  let puntuacion = 10;

  // Enviar la puntuación al servidor
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./PHP/puntuacionCartas.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function() {
    if (xhr.status === 200) {
      alert(xhr.responseText); // Mostrar la respuesta del servidor
    } else {
      alert("Hubo un error al enviar la puntuación al servidor");
    }
  };

  // Enviar la puntuación como parámetro
  xhr.send("puntuacion=" + puntuacion);
}


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
/*Juego 4*/
const wordContainer = document.getElementById('wordContainer');
const startButton = document.getElementById('startButton');
const usedLettersElement = document.getElementById('usedLetters');

let canvas = document.getElementById('canvas');
let ctx = canvas.getContext('2d');
ctx.canvas.width = 0;
ctx.canvas.height = 0;
const bodyParts = [
  [2, 3, 1, 1], 
  [2, 4, 1, 2], 
  [1, 4, 1, 1],
  [3, 4, 1, 1],
  [1, 6, 1, 1], 
  [3, 6, 1, 1] 
];
let selectWord;
let usedLetters;
let mistakes;
let hits;

const addLetter = letter => {
  const letterElement = document.createElement('span');
  letterElement.innerHTML = letter.toUpperCase();
  usedLettersElement.appendChild(letterElement);
}

const addBodyPart = bodyPart => {
  ctx.fillStyle = '#fff';
  ctx.strokeStyle = '#fff';
  ctx.lineWidth = 0.5;
  switch (mistakes) {
    case 0:
      ctx.beginPath();
      ctx.arc(4.5, 2.8, 1, 0, 2 * Math.PI);
      ctx.stroke();
      break;
    case 1:
      ctx.beginPath();
      ctx.moveTo(4.5, 3.8);
      ctx.lineTo(4.5, 5.8);
      ctx.stroke();
      break;
    case 2:
      ctx.beginPath();
      ctx.moveTo(4.5, 4.8);
      ctx.lineTo(3, 3.8);
      ctx.stroke();
      break;
    case 3:
      ctx.beginPath();
      ctx.moveTo(4.5, 4.8);
      ctx.lineTo(6, 3.8);
      ctx.stroke();
      break;
    case 4:
      ctx.beginPath();
      ctx.moveTo(4.5, 5.5);
      ctx.lineTo(3.5, 6.8);
      ctx.stroke();
      break;
    case 5:
      ctx.beginPath();
      ctx.moveTo(4.5, 5.5);
      ctx.lineTo(5.5, 6.8);
      ctx.stroke();
      break;
    default:
      break;
  }
}

const wrongLetter = () => {
  addBodyPart(bodyParts[mistakes]);
  mistakes++;
  if(mistakes === bodyParts.length) endGame();
}

const endGame = () =>{
  document.removeEventListener('keydown', letterEvent);
  startButton.style.display = 'block';
}

const correctLetter = letter => {
  const{children} = wordContainer;
  for(let i = 0; i<children.length;i++){
    if(children[i].innerHTML === letter){
        children[i].classList.toggle('hidden');
        hits++;
    }
  }
  if (hits === selectWord.length) {
    endGame();
    let formData = new FormData();
    formData.append('puntos', 5);
    fetch('./PHP/ActualizarPuntuacionAhorcados.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch(error => console.error(error));
  }

}


const letterInput= letter =>{
  if(selectWord.includes(letter)){
    correctLetter(letter);
  }else{
    wrongLetter();
  }
  addLetter(letter);
  usedLetters.push(letter);
}

const letterEvent = event => {
  let newLetter = event.key.toUpperCase();
  if(newLetter.match(/^[a-zñ]$/i) && !usedLetters.includes(newLetter)){
    letterInput(newLetter);
  }
};

const drawWord = () => {
  selectWord.forEach(letter=>{
    const letterElement =  document.createElement('span');
    letterElement.innerHTML = letter.toUpperCase();
    letterElement.classList.add('letter');
    letterElement.classList.add('hidden');
    wordContainer.appendChild(letterElement);
  });
};

let words = [];
fetch('./PHP/getWords.php')
    .then(response => response.json())
    .then(data => {
        words = data;
    });

const selectRandomWord = () =>{
  let word = words[Math.floor((Math.random()*words.length))].toUpperCase();
  selectWord = word.split('');
};

const drawHangMan = () => {
  ctx.canvas.width = 122;
  ctx.canvas.height = 160;
  ctx.scale(20,20);
  ctx.clearRect(0,0, canvas.width, canvas.height);
  ctx.fillStyle = '#4b3621';
  ctx.fillRect(0, 7, 4, 1);
  ctx.fillRect(1, 0, 1, 8);
  ctx.fillRect(2, 0, 3, 1);
  ctx.fillRect(4, 1, 1, 1);
};
const startGame = ()=>{
  usedLetters = [];
  mistakes = 0;
  hits = 0;
  wordContainer.innerHTML = '';
  usedLettersElement.innerHTML='';
  startButton.style.display='none';
  drawHangMan();
  selectRandomWord();
  drawWord();
  document.addEventListener('keydown', letterEvent)
};
startButton.addEventListener('click',startGame);
/*Fin Juego 4*/
/*Juego 5*/
const myCanvas = document.getElementById("canvas");
const ctx2 = myCanvas.getContext("2d");
const principal = document.getElementById("principal");
const rojo = document.getElementById("rojo");
const azul = document.getElementById("azul");
let cajas = [];
let puntuacion = 0;
function crearCajas() {
  for (let i = 0; i < 12; i++) {
    let caja = document.createElement("div");
    caja.classList.add("caja");
    caja.style.width = 100;
    caja.style.height = 100;
    caja.style.backgroundColor = i % 2 ? "red" : "blue";
    principal.appendChild(caja);
    cajas.push(caja);
  }
}
function dibujarCajas() {
  ctx2.clearRect(0, 0, myCanvas.width, myCanvas.height);
  for (let caja of cajas) {
    ctx2.fillStyle = caja.style.backgroundColor;
    ctx2.fillRect(caja.offsetLeft, caja.offsetTop, caja.offsetWidth, caja.offsetHeight);
  }
}
function arrastrarCajas() {
  for (let caja of cajas) {
    caja.addEventListener("mousedown", function(e) {
      this.style.cursor = "move";
      this.startX = e.clientX;
      this.startY = e.clientY;
    });

    caja.addEventListener("mouseup", function(e) {
      this.style.cursor = "default";
      let x = e.clientX - this.startX;
      let y = e.clientY - this.startY;
      this.style.left = x + "px";
      this.style.top = y + "px";
    });

    caja.addEventListener("mousemove", function(e) {
      let x = e.clientX - this.startX;
      let y = e.clientY - this.startY;
      this.style.left = x + "px";
      this.style.top = y + "px";
    });
  }
}
function evaluarCajas() {
  for (let i = 0; i < 6; i++) {
    let caja = cajas[i];
    if (caja.classList.contains("rojo") && caja.parentElement === rojo) {
      puntuacion++;
    } else if (caja.classList.contains("azul") && caja.parentElement === azul) {
      puntuacion++;
    }
  }

  document.getElementById("puntuacion").innerHTML = puntuacion;
}
function reiniciarJuego() {
  for (let caja of cajas) {
    caja.style.left = 0;
    caja.style.top = 0;
    caja.classList.remove("rojo", "azul");
  }
  puntuacion = 0;
  document.getElementById("puntuacion").innerHTML = puntuacion;
}
crearCajas();
dibujarCajas();
arrastrarCajas();
document.addEventListener("mouseup", evaluarCajas);
document.getElementById("reiniciar").addEventListener("click", reiniciarJuego);

/*Fin Juego 5*/
/*Juego 6*/
/*Fin Juego 6*/