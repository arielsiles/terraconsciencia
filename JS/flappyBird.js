document.getElementById('startGame').addEventListener('click', function () {
    const canvas = document.getElementById('game-canvas');
    const ctx = canvas.getContext('2d');
    const gameContainer = document.getElementById('game-container');

    const flappyImg = new Image();
    flappyImg.src = './IMG/flappy.png';

    const FLAP_SPEED = -4;
    const BIRD_WIDTH = 40;
    const BIRD_HEIGHT = 30;
    const PIPE_WIDTH = 50;
    const PIPE_GAP = 125;

    let birdX = 50;
    let birdY = 50;
    let birdVelocity = 0;
    let birdAcceleration = 0.1;

    let pipeX = 500;
    let pipeY = canvas.height - 200;

    let scoreDiv = document.getElementById('score-display');
    let score = 0;
    let highScore = 0;

    let scored = false;

    document.body.addEventListener('keyup', function (e) {
        if (e.code === 'Space') {
            birdVelocity = FLAP_SPEED;
        }
    });

    let clicsReinicio = 0;

    document.getElementById('restart-button').addEventListener('click', function () {
        hideEndMenu();
        hideGgMenu();
        clicsReinicio++;

        if (clicsReinicio >= 3) {
            this.disabled = true;
            return;
        }
        restGame();
        loop();
    });

    document.getElementById('restart-button-gg').addEventListener('click', function () {
        hideGgMenu();
        clicsReinicio++;

        if (clicsReinicio >= 3) {
            this.disabled = true;
            return;
        }
        restGame();
        loop();
    });

    function increaseScore() {
        if (birdX > pipeX + PIPE_WIDTH &&
            (birdY < pipeY + PIPE_GAP ||
                birdY + BIRD_HEIGHT > pipeY + PIPE_GAP) && !scored) {
            score++;
            scoreDiv.innerHTML = score;
            scored = true;
        }
        if (birdX < pipeX + PIPE_WIDTH) {
            scored = false;
        }
    }

    function collisionCheck() {
        const birdBox = {
            x: birdX, y: birdY, width: BIRD_WIDTH, height: BIRD_HEIGHT
        }

        const pipeBox = {
            x: pipeX, y: topTube ? 0 : canvas.height / 2, width: PIPE_WIDTH, height: canvas.height / 2
        }

        if (birdBox.x + birdBox.width > pipeBox.x &&
            birdBox.x < pipeBox.x + pipeBox.width &&
            birdBox.y < pipeBox.y + pipeBox.height &&
            birdBox.y + birdBox.height > pipeBox.y) {
            return true;
        }
        if (birdY < 0 || birdY + BIRD_HEIGHT > canvas.height) {
            return true;
        }
    }

    function hideGgMenu() {
        document.getElementById('gg-menu').style.display = 'none';
        gameContainer.classList.remove('backdrop-blur');
    }

    function hideEndMenu() {
        document.getElementById('end-menu').style.display = 'none';
        gameContainer.classList.remove('backdrop-blur');
    }

    function showEndMenu() {
        document.getElementById('end-menu').style.display = 'block';
        gameContainer.classList.add('backdrop-blur');
        document.getElementById('end-score').innerHTML = score;

        if (highScore < score) {
            highScore = score;
        }
        document.getElementById('best-score').innerHTML = highScore;
    }

    function showGgMenu() {
        document.getElementById('gg-menu').style.display = 'block';
        gameContainer.classList.add('backdrop-blur');
        document.getElementById('best-score').innerHTML = '10';
    }

    function restGame() {
        birdX = 50;
        birdY = 50;
        birdVelocity = 0;
        birdAcceleration = 0.1;

        pipeX = 500;
        pipeY = canvas.height - 200;

        score = 0;
        tubosGenerados = 0;
    }

    function endGame() {
        showEndMenu();
        fetch('./PHP/actualizarPuntuacionAvion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'puntuacion=' + score,
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Error en la solicitud Fetch: ' + error);
        });
    }

    function gg() {
        showGgMenu();
    }

    document.addEventListener("keydown", function (event) {
        if (event.key === " ") {
            event.preventDefault();
        }
    });

    let topTube;
    let tubosGenerados = 0;
    let mostrarMensajePrevio = true;
    var gameOver = false;

    let mensajesPrevios = [];
    let mensajesBuenos = [];
    let mensajesMalos = [];

    $.ajax({
    url: './PHP/obtenerMensajes.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
        mensajesPrevios = data.mensajesPrevios;
        mensajesBuenos = data.mensajesBuenos;
        mensajesMalos = data.mensajesMalos;

        loop();
    },
     error: function (xhr, status, error) {
        console.error('Error en la solicitud AJAX:', error);
        console.error('Estado (status):', status);
        console.error('Respuesta (responseText):', xhr.responseText);
    }
    });

    function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
        var words = text.split(' ');
        var line = '';
        y += lineHeight;
        for (var i = 0; i < words.length; i++) {
            var testLine = line + words[i] + ' ';
            var metrics = ctx.measureText(testLine);
            var testWidth = metrics.width;
            if (testWidth > maxWidth && i > 0) {
                ctx.fillText(line, x, y);
                line = words[i] + ' ';
                y += lineHeight;
            } else {
                line = testLine;
            }
        }
        ctx.fillText(line, x, y);
    }

    function loop() {
        if (gameOver) {
            return;
        }

        ctx.clearRect(0, 0, canvas.clientWidth, canvas.height);
        ctx.drawImage(flappyImg, birdX, birdY);

        ctx.setLineDash([5, 15]);
        ctx.strokeStyle = 'transparent';

        var rectWidth = 180;
        var rectHeight = 120;

        if (topTube) {
            ctx.strokeRect(pipeX, 0, PIPE_WIDTH, canvas.height / 2);
            ctx.strokeRect(pipeX, canvas.height / 2, PIPE_WIDTH, canvas.height / 2);
            ctx.fillStyle = 'white';
            ctx.fillRect(pipeX + (PIPE_WIDTH - rectWidth) / 2, canvas.height / 4 - rectHeight / 2, rectWidth, rectHeight);
            ctx.fillStyle = 'black';
            wrapText(ctx, mensajesMalos[tubosGenerados], pipeX + (PIPE_WIDTH - rectWidth) / 2 + 20, canvas.height / 4 - rectHeight / 2 + 20, rectWidth - 40, 20);
            ctx.fillStyle = 'white';
            ctx.fillRect(pipeX + (PIPE_WIDTH - rectWidth) / 2, canvas.height * 3 / 4 - rectHeight / 2, rectWidth, rectHeight);
            ctx.fillStyle = 'black';
            wrapText(ctx, mensajesBuenos[tubosGenerados], pipeX + (PIPE_WIDTH - rectWidth) / 2 + 20, canvas.height * 3 / 4 - rectHeight / 2 + 20, rectWidth - 40, 20);
        } else {
            ctx.strokeRect(pipeX, canvas.height / 2, PIPE_WIDTH, canvas.height / 2);
            ctx.strokeRect(pipeX, 0, PIPE_WIDTH, canvas.height / 2);
            ctx.fillStyle = 'white';
            ctx.fillRect(pipeX + (PIPE_WIDTH - rectWidth) / 2, canvas.height / 4 - rectHeight / 2, rectWidth, rectHeight);
            ctx.fillStyle = 'black';
            wrapText(ctx, mensajesBuenos[tubosGenerados], pipeX + (PIPE_WIDTH - rectWidth) / 2 + 20, canvas.height / 4 - rectHeight / 2 + 20, rectWidth - 40, 20);
            ctx.fillStyle = 'white';
            ctx.fillRect(pipeX + (PIPE_WIDTH - rectWidth) / 2, canvas.height * 3 / 4 - rectHeight / 2, rectWidth, rectHeight);
            ctx.fillStyle = 'black';
            wrapText(ctx, mensajesMalos[tubosGenerados], pipeX + (PIPE_WIDTH - rectWidth) / 2 + 20, canvas.height * 3 / 4 - rectHeight / 2 + 20, rectWidth - 40, 20);
        }

        ctx.setLineDash([]);

        if (collisionCheck()) {
            endGame();
            return;
        }

        pipeX -= 1.0;
        if (pipeX < -50) {
            pipeX = 500;
            topTube = Math.random() < 0.5;
            mostrarMensajePrevio = true;

            tubosGenerados++;

            if (tubosGenerados >= 10) {
                gameOver = true;
                gg();
                return;
            }
        }

        if (mostrarMensajePrevio && tubosGenerados < mensajesPrevios.length) {
            ctx.font = "16px Arial";
            ctx.fillText(mensajesPrevios[tubosGenerados], (canvas.width / 2) - (ctx.measureText(mensajesPrevios[tubosGenerados]).width / 2), canvas.height / 2);
        }

        birdVelocity += birdAcceleration;
        birdY += birdVelocity;
        increaseScore();
        requestAnimationFrame(loop);
    }
});