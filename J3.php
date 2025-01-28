<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
include "./PHP/popups.php";
include "./PHP/fov.php";
$roles_permitidos = ['Administrador','Usuario'];
if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
    header("Location: SinLogin.php");
    session_destroy();
    die();
} /*else {
    if ($_SESSION['rol'] == 'Administrador') {
        header("Location: J3Adm.php");
    }
}*/
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Terra ConsCiencia</title>

    <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> <!-- Para íconos -->

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">



</head>

<body>

<?php include 'header_info.php'; ?>

<?php include 'main_menu_user.php'; ?>

<main>

    <section class="cta-section section-padding section-bg">

        <div class="container py-4">
            <div class="row">
                <!-- Botón para regresar -->
                <div class="col-12 mb-3 text-end">
                    <a href="Trivias.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-circle-left"></i> Volver Atrás
                    </a>
                </div>

                <!-- Sección de texto inicial -->
                <div id="actFVTxt" class="col-12 text-center">
                    <h2 class="mb-2 text-info">Áreas de Recarga Hídrica</h2>
                    <h5 class="mb-4 text-secondary">Lee atentamente y responde</h5>

                    <p class="lead">
                        Una <strong>cuenca hidrográfica</strong> es un territorio determinado por la cumbre de los cerros, donde las aguas confluyen hacia un río principal. Una cuenca está formada por <span class="text-info">quebradas, acequias, riachuelos y vertientes</span> donde se moviliza el agua dulce hasta llegar a un punto único de desfogue llamado <em>punto de salida</em>, que usualmente es un río principal o mar. Las cuencas hidrográficas tienen como fin captar o recoger el agua de lluvia que alimenta a los ríos, quebradas, vertientes, lagos, lagunas y represas.
                    </p>

                    <p class="text-start">
                        <strong>Partes de una cuenca hidrográfica:</strong> Una cuenca puede estar constituida por otras zonas donde la recarga hídrica puede ser significativa. Las más importantes son:
                    </p>

                    <ul class="list-group list-group-flush text-start mb-4">
                        <li class="list-group-item">
                            <strong>a)</strong> <span class="fw-bold">Cuenca alta:</span> Donde se originan los ríos y quebradas, con mayor concentración de áreas de recarga hídrica al existir mayor captación de agua de lluvia.
                        </li>
                        <li class="list-group-item">
                            <strong>b)</strong> <span class="fw-bold">Cuenca media:</span> Encargada de transportar el agua proveniente desde la zona alta hacia la parte baja, donde se concentra la mayor densidad hídrica conformada por lagunas, ríos, quebradas y vertientes.
                        </li>
                        <li class="list-group-item">
                            <strong>c)</strong> <span class="fw-bold">Cuenca baja:</span> Es la zona más caudalosa que concentra la mayor cantidad de agua proveniente de las otras dos zonas.
                        </li>
                    </ul>

                    <p class="lead">
                        Es un sitio de mayor aprovechamiento ya que se usa en riego, consumo humano, ganadería e industria.
                    </p>

                    <p class="text-start">
                        <strong>Importancia de las cuencas hidrográficas:</strong>
                    </p>

                    <ol class="list-group list-group-numbered text-start mb-4">
                        <li class="list-group-item">Permiten la captación y acumulación de agua en el suelo.</li>
                        <li class="list-group-item">Permiten el riego para especies cultivadas, dotando de alimentos a las familias cercanas a la cuenca y de la zona.</li>
                        <li class="list-group-item">Su buen manejo reduce los riesgos de desastres naturales como las inundaciones, deslizamientos, erosión de suelos.</li>
                        <li class="list-group-item">Ofrecen servicios ambientales como aire puro, agua, suelo fértil, humedad.</li>
                        <li class="list-group-item">Se convierten en un hábitat para especies vegetales y/o animales silvestres.</li>
                        <li class="list-group-item">Promueven la recreación y el turismo sostenible.</li>
                    </ol>

                    <p class="text-start">
                        <strong>El área de recarga hídrica:</strong> Es la zona geográfica que, por sus características naturales, capta, almacena e incorpora el agua procedente de la lluvia al subsuelo, aguas superficiales y a otros acuíferos y cuerpos de agua estáticos y/o en movimiento. La capacidad de un área de recarga hídrica (cuenca, subcuenca o sitio específico), está definida por:
                    </p>

                    <ul class="list-group list-group-flush text-start mb-4">
                        <li class="list-group-item">Cobertura vegetal permanente.</li>
                        <li class="list-group-item">Mayor diversidad y combinación de plantaciones (forestales nativos o exóticos, arbustos, hierbas y pastos).</li>
                        <li class="list-group-item">Tipo de suelo, especialmente la textura, un factor importante para determinar la capacidad de recarga hídrica. Los suelos impermeables y compactados impiden o dificultan la infiltración, mientras que los suelos permeables facilitan la recarga.</li>
                    </ul>

                    <p class="text-start">
                        <strong>Las acciones para recuperar áreas de recarga hídrica son:</strong>
                    </p>

                    <ul class="list-group list-group-flush text-start">
                        <li class="list-group-item">Promover e incentivar la regeneración de la cobertura arbórea, arbustiva o pastizales naturales dentro del área.</li>
                        <li class="list-group-item">Realizar acciones de reforestación, sistemas agroforestales y prácticas agroecológicas.</li>
                        <li class="list-group-item">Controlar y evitar la quema en las áreas de recarga y descarga, no contaminar el agua, ni matar la vegetación.</li>
                        <li class="list-group-item">Evitar el sobrepastoreo y la agricultura convencional (uso de agroquímicos).</li>
                        <li class="list-group-item">Evaluar para identificar si es necesario aislar o impedir el ingreso de personas o animales para que recupere, mantenga o incremente su cobertura vegetal.</li>
                    </ul>

                    <button class="btn btn-primary mt-4 px-5 py-2" onclick="mostrarPreguntas()">Continuar <i class="fas fa-arrow-right"></i></button>
                </div>



                <!-- Sección del test de preguntas -->
                <div id="actFV" class="col-12 d-none">
                    <form id="formFV">
                        <!-- Preguntas dinámicas -->
                        <div id="preguntasContainer"></div>

                        <!-- Botones de acción -->
                        <div class="mt-4 text-center">
                            <button type="button" class="btn btn-success" onclick="calcularPuntuacion()">Calcular Resultado</button>
                            <button type="button" class="btn btn-warning" onclick="volverTexto()">Volver al Texto</button>
                        </div>
                    </form>

                    <!-- Resultado -->
                    <div id="resultadoFV" class="mt-4 d-none text-center">
                        <h2>Resultado</h2>
                        <p id="puntuacionFV" class="fs-4 fw-bold"></p>
                    </div>
                </div>
            </div>
        </div>


    </section>


</main>

<?php include 'footer.php'; ?>

<!-- JAVASCRIPT FILES -->

<script src="JS/jquery.min.js"></script>
<script src="JS/bootstrap.min.js"></script>
<script src="JS/jquery.sticky.js"></script>
<!--<script src="JS/click-scroll.js"></script>
<script src="JS/counter.js"></script>
<script src="JS/custom.js"></script>-->

<script src="JS/scriptJuego3.js"></script>

</body>

</html>