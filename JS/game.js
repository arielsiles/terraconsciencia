function crearElementosHTML(rutas) {
    let juego = document.getElementById('juego');
    let canvas = document.createElement('canvas');
    canvas.width = 900;
    canvas.height = 500;
    juego.appendChild(canvas);

    let ctx = canvas.getContext('2d');

    let contenedorGeneral = { x: 0, y: 0, width: 800, height: 500 };
    let contenedorSeleccion1 = { x: 610, y: 0, width: 300, height: 250 };
    let contenedorSeleccion2 = { x: 610, y: 250, width: 300, height: 250 };
    let contenedorVacio = { width: 80, height: 80 };
    let divMovil = { width: 80, height: 80 };

    let divsMoviles = [];

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    shuffleArray(rutas);

    for (let i = 0; i < 12; i++) {
        let x = contenedorGeneral.x + (i % 6) * (contenedorVacio.width + 10) + 10;
        let y = contenedorGeneral.y + Math.floor(i / 6) * (contenedorVacio.height + 10) + 10;
        let imagen = rutas[i];
        divsMoviles.push({ x, y, imagen, arrastrando: false });
    }
    dibujarJuego();
    let movimientoHabilitado = true;

    function dibujarJuego() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        ctx.fillStyle = 'lightgray';
        ctx.fillRect(contenedorGeneral.x, contenedorGeneral.y, contenedorGeneral.width, contenedorGeneral.height);

        ctx.fillStyle = 'lightgray';
        ctx.fillRect(contenedorSeleccion1.x, contenedorSeleccion1.y, contenedorSeleccion1.width, contenedorSeleccion1.height);
        ctx.fillRect(contenedorSeleccion2.x, contenedorSeleccion2.y, contenedorSeleccion2.width, contenedorSeleccion2.height);

        ctx.fillStyle = 'black';
        ctx.font = '24px sans-serif';
        ctx.fillText(nombreContenedorAzul, contenedorSeleccion1.x + 10, contenedorSeleccion1.y + 30);
        ctx.fillText(nombreContenedorRojo, contenedorSeleccion2.x + 10, contenedorSeleccion2.y + 30);

        for (let i = 0; i < 6; i++) {
            let x1 = contenedorSeleccion1.x + (i % 3) * (contenedorVacio.width + 10) + 10;
            let y1 = contenedorSeleccion1.y + Math.floor(i / 3) * (contenedorVacio.height + 10) + 50;

            let x2 = contenedorSeleccion2.x + (i % 3) * (contenedorVacio.width + 10) + 10;
            let y2 = contenedorSeleccion2.y + Math.floor(i / 3) * (contenedorVacio.height + 10) + 50;

            ctx.strokeRect(x1, y1, contenedorVacio.width, contenedorVacio.height);
            ctx.strokeRect(x2, y2, contenedorVacio.width, contenedorVacio.height);
        }

        for (let i = 0; i < divsMoviles.length; i++) {
            let imagenMovil = new Image();
            imagenMovil.src = divsMoviles[i].imagen;
            ctx.drawImage(imagenMovil, divsMoviles[i].x, divsMoviles[i].y, divMovil.width, divMovil.height);
        }
    }

    let evaluarButton = document.createElement('button');
    evaluarButton.textContent = 'Evaluar';
    evaluarButton.id = 'evaluarButton';
    evaluarButton.disabled = true;
    evaluarButton.classList.add('button');
    juego.appendChild(evaluarButton);

    evaluarButton.addEventListener('click', function () {
        movimientoHabilitado = false;
        evaluarButton.disabled = true;

        calcularPuntuacion(contenedorSeleccion1, contenedorSeleccion2, contenedorVacio, divsMoviles);

        dibujarJuego();
    });

    dibujarJuego();

    let elementoArrastrado = null;
    let posicionInicial = null;

    canvas.addEventListener('mousedown', function (event) {
        if (!movimientoHabilitado) {
            return;
        }

        let rect = canvas.getBoundingClientRect();
        let mouseX = event.clientX - rect.left;
        let mouseY = event.clientY - rect.top;

        for (let i = 0; i < divsMoviles.length; i++) {
            if (mouseX >= divsMoviles[i].x && mouseX <= divsMoviles[i].x + divMovil.width &&
                mouseY >= divsMoviles[i].y && mouseY <= divsMoviles[i].y + divMovil.height) {
                elementoArrastrado = divsMoviles[i];
                elementoArrastrado.arrastrando = true;
                divsMoviles.splice(i, 1);
                posicionInicial = { x: elementoArrastrado.x, y: elementoArrastrado.y };
                break;
            }
        }
    });

    canvas.addEventListener('mousemove', function (event) {
        if (!movimientoHabilitado) {
            return;
        }

        let rect = canvas.getBoundingClientRect();
        let mouseX = event.clientX - rect.left;
        let mouseY = event.clientY - rect.top;
        elementoArrastrado.x = mouseX - divMovil.width / 2;
        elementoArrastrado.y = mouseY - divMovil.height / 2;

        dibujarJuego();
        let imagenArrastrada = new Image();
        imagenArrastrada.src = elementoArrastrado.imagen;
        ctx.drawImage(imagenArrastrada, elementoArrastrado.x, elementoArrastrado.y, divMovil.width, divMovil.height);
    });

    canvas.addEventListener('mouseup', function (event) {
        if (!movimientoHabilitado) {
            return;
        }

        let rect = canvas.getBoundingClientRect();
        let mouseX = event.clientX - rect.left;
        let mouseY = event.clientY - rect.top;

        for (let i = 0; i < 6; i++) {
            let x1 = contenedorSeleccion1.x + (i % 3) * (contenedorVacio.width + 10) + 10;
            let y1 = contenedorSeleccion1.y + Math.floor(i / 3) * (contenedorVacio.height + 10) + 50;

            if (mouseX >= x1 && mouseX <= x1 + contenedorVacio.width &&
                mouseY >= y1 && mouseY <= y1 + contenedorVacio.height) {
                let ocupado = false;
                for (let j = 0; j < divsMoviles.length; j++) {
                    if (divsMoviles[j].x === x1 && divsMoviles[j].y === y1) {
                        ocupado = true;
                        break;
                    }
                }
                if (!ocupado) {
                    elementoArrastrado.x = x1;
                    elementoArrastrado.y = y1;
                } else {
                    elementoArrastrado.x = posicionInicial.x;
                    elementoArrastrado.y = posicionInicial.y;
                }
                break;
            }

            let x2 = contenedorSeleccion2.x + (i % 3) * (contenedorVacio.width + 10) + 10;
            let y2 = contenedorSeleccion2.y + Math.floor(i / 3) * (contenedorVacio.height + 10) + 50;

            if (mouseX >= x2 && mouseX <= x2 + contenedorVacio.width &&
                mouseY >= y2 && mouseY <= y2 + contenedorVacio.height) {
                let ocupado = false;
                for (let j = 0; j < divsMoviles.length; j++) {
                    if (divsMoviles[j].x === x2 && divsMoviles[j].y === y2) {
                        ocupado = true;
                        break;
                    }
                }
                if (!ocupado) {
                    elementoArrastrado.x = x2;
                    elementoArrastrado.y = y2;
                } else {
                    elementoArrastrado.x = posicionInicial.x;
                    elementoArrastrado.y = posicionInicial.y;
                }
                break;
            }
        }

        elementoArrastrado.arrastrando = false;
        divsMoviles.push(elementoArrastrado);
        elementoArrastrado = null;

        dibujarJuego();
    });

    function todosRectangulosVaciosLlenos() {
        for (let i = 0; i < 6; i++) {
            let x1 = contenedorSeleccion1.x + (i % 3) * (contenedorVacio.width + 10) + 10;
            let y1 = contenedorSeleccion1.y + Math.floor(i / 3) * (contenedorVacio.height + 10) + 50;
            let x2 = contenedorSeleccion2.x + (i % 3) * (contenedorVacio.width + 10) + 10;
            let y2 = contenedorSeleccion2.y + Math.floor(i / 3) * (contenedorVacio.height + 10) + 50;

            let rectanguloVacio1Lleno = false;
            let rectanguloVacio2Lleno = false;

            for (let j = 0; j < divsMoviles.length; j++) {
                let x = divsMoviles[j].x;
                let y = divsMoviles[j].y;

                if (x === x1 && y >= y1 && y <= y1 + contenedorVacio.height) {
                    rectanguloVacio1Lleno = true;
                }

                if (x === x2 && y >= y2 && y <= y2 + contenedorVacio.height) {
                    rectanguloVacio2Lleno = true;
                }
            }

            if (!rectanguloVacio1Lleno || !rectanguloVacio2Lleno) {
                return false;
            }
        }

        return true;
    }

    canvas.addEventListener('mouseup', function () {
        evaluarButton.disabled = !todosRectangulosVaciosLlenos();
    });
    dibujarJuego();
}

function calcularPuntuacion(contenedorSeleccion1, contenedorSeleccion2, contenedorVacio, divsMoviles) {
    let puntuacion = 0;

    for (let i = 0; i < 6; i++) {
        let x1 = contenedorSeleccion1.x + (i % 3) * (contenedorVacio.width + 10) + 10;
        let y1 = contenedorSeleccion1.y + Math.floor(i / 3) * (contenedorVacio.height + 10) + 50;
        let x2 = contenedorSeleccion2.x + (i % 3) * (contenedorVacio.width + 10) + 10;
        let y2 = contenedorSeleccion2.y + Math.floor(i / 3) * (contenedorVacio.height + 10) + 50;

        for (let j = 0; j < divsMoviles.length; j++) {
            let x = divsMoviles[j].x;
            let y = divsMoviles[j].y;

            if (x === x1 && y >= y1 && y <= y1 + contenedorVacio.height && divsMoviles[j].imagen.includes('azul')) {
                puntuacion++;
            }

            if (x === x2 && y >= y2 && y <= y2 + contenedorVacio.height && divsMoviles[j].imagen.includes('rojo')) {
                puntuacion++;
            }
        }
    }

    let puntuacionElement = document.createElement('p');
    puntuacionElement.id = 'Puntuacion';
    puntuacionElement.textContent = 'Puntuación: ' + puntuacion;
    let juego = document.getElementById('juego');
    juego.appendChild(puntuacionElement);

    let xhr = new XMLHttpRequest();
    xhr.open('POST', './PHP/actualizarPuntuacionSeleccion.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    let datos = 'puntos=' + puntuacion;
    
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
        }
    };
    
    xhr.send(datos);
}


let nombreContenedorAzul = ''; 
let nombreContenedorRojo = ''; 

function cargarNombresDesdePHP() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', './PHP/obtenerNombres.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            let nombresDesdePHP = JSON.parse(xhr.responseText);
            nombreContenedorRojo = nombresDesdePHP.nombreContenedorRojo;
            nombreContenedorAzul = nombresDesdePHP.nombreContenedorAzul;
        }
    };
    xhr.send();
}

function cargarRutasDesdePHP() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', './PHP/obtenerImagenes.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            let rutasDesdePHP = JSON.parse(xhr.responseText);
            crearElementosHTML(rutasDesdePHP);
        }
    };
    xhr.send();
}

document.addEventListener('DOMContentLoaded', function () {
    cargarNombresDesdePHP();
    cargarRutasDesdePHP();
});
