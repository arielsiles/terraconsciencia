<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
include "./PHP/popups.php";
$roles_permitidos = ['Administrador', 'Usuario'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: SinLogin.php");
    session_destroy();
    die();
} /*else {
    if ($_SESSION['rol'] == 'Administrador') {
        header("Location: J5Adm.php");
    }
}*/

include "./PHP/conexionBe.php";
// Consulta para obtener las imágenes
$sql = "SELECT ruta, valor FROM img_ord";
$result = $conexion->query($sql);

// Comprobar si hay resultados
$images = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Clasificación</title>
    <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container-game {
            padding: 20px;
        }

        .image-container {
            border: 2px dashed #aaa;
            border-radius: 10px;
            padding: 10px;
            min-height: 200px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .image-container img {
            width: 100px;
            height: auto;
            max-height: 100px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .image-container img.selected {
            border: 2px solid #007bff;
            border-radius: 5px;
        }

        .modal img {
            max-width: 100%;
            height: auto;
        }

        .evaluate-btn {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        @media (max-width: 576px) {
            .image-container img {
                width: 80px;
                max-height: 80px;
            }
        }
    </style>
</head>
<body>
<div class="container-game">
    <h1 class="text-center">Ordena, elige sabiamente y gana!!!</h1>
    <p class="text-center">Haz clic en una imagen para seleccionarla, y decide a qué contenedor moverla con un click.</p>

    <!-- Contenedor general de imágenes -->
    <div id="general-container" class="image-container bg-light">
        <h3 id="score-title" class="text-center d-none">Puntuación: <span id="score">0</span></h3>
        <?php foreach ($images as $image): ?>
            <img src="<?php echo $image['ruta']; ?>" alt="Imagen" data-type="<?php echo $image['valor']; ?>">
        <?php endforeach; ?>
    </div>

    <!-- Contenedores de destino -->
    <div id="transgenico-container" class="image-container bg-danger bg-opacity-25 mt-2">
        <h5 class="w-100">Contenedor Transgénicos</h5>
    </div>
    <div id="organico-container" class="image-container bg-success bg-opacity-25 mt-2">
        <h5 class="w-100">Contenedor Orgánicos</h5>
    </div>

    <!-- Botones de acción -->
    <div class="evaluate-btn">
        <a href="Trivias.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver atrás
        </a>
        <button id="evaluate-btn" class="btn btn-primary" disabled>Evaluar</button>
    </div>
</div>

<!-- Modal para ampliar imágenes -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Visualización de Imagen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modal-image" src="" alt="Imagen ampliada">
            </div>
        </div>
    </div>
</div>

<script>
    let score = 0;
    const scoreDisplay = document.getElementById("score");
    const evaluateBtn = document.getElementById("evaluate-btn");
    const scoreTitle = document.getElementById("score-title");
    let selectedImage = null;

    // Seleccionar imagen al hacer clic
    document.querySelectorAll(".image-container img").forEach(img => {
        img.addEventListener("click", () => {
            document.querySelectorAll(".image-container img").forEach(img => img.classList.remove("selected"));
            selectedImage = img;
            img.classList.add("selected");

            const modalImage = document.getElementById("modal-image");
            modalImage.src = img.src;
            const modal = new bootstrap.Modal(document.getElementById("imageModal"));
            modal.show();
        });
    });

    // Mover imagen al contenedor de destino
    document.querySelectorAll(".image-container").forEach(container => {
        container.addEventListener("click", () => {
            if (selectedImage && container.id !== selectedImage.parentElement.id) {
                container.appendChild(selectedImage);
                selectedImage.classList.remove("selected");
                selectedImage = null;
                checkImagesMoved();
            }
        });
    });

    function checkImagesMoved() {
        const generalContainer = document.getElementById("general-container");
        evaluateBtn.disabled = generalContainer.querySelectorAll("img").length !== 0;
    }

    // Evaluar y mostrar el puntaje
    evaluateBtn.addEventListener("click", () => {
        score = 0;
        const transgenicoContainer = document.getElementById("transgenico-container");
        const organicoContainer = document.getElementById("organico-container");

        transgenicoContainer.querySelectorAll("img").forEach(img => {
            if (img.dataset.type === "transgenico") {
                score++;
            }
        });

        organicoContainer.querySelectorAll("img").forEach(img => {
            if (img.dataset.type === "organico") {
                score++;
            }
        });

        scoreDisplay.textContent = score;
        scoreTitle.classList.remove("d-none");

        alert(`¡Juego terminado! Tu puntuación es: ${score}`);
        sendScoreToServer(score);
    });

    function sendScoreToServer(puntos) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./PHP/actualizarPuntuacionSeleccion.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = () => {
            if (xhr.status === 200) {
                alert(xhr.responseText);
            } else {
                alert("Hubo un problema al actualizar la puntuación.");
            }
        };
        xhr.send(`puntos=${puntos}`);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
