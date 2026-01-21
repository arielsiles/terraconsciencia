<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    include './PHP/conexionBe.php';
    include './PHP/perfil.php';
    if(!isset($_SESSION['usuario'])){
        echo'
            <script>
                alert("Debe iniciar Sesion")
                window.location = "SinLogin.php";
            </script>
        ';
        session_destroy();
        die();
    }
    $idUser = $_SESSION['usuario'];
    $sql = "SELECT id, nombre_usuario, correo, fecha, puntos, perfil FROM usuarios WHERE nombre_usuario = '$idUser'";
    $resultado = $conexion -> query($sql);
    $row = $resultado -> fetch_assoc();
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

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


</head>

<body>

<?php include 'header_info.php'; ?>

<?php include 'modal_cierre.php'; ?>

<?php include 'main_menu_user.php'; ?>

<main>

    <section class="news-section py-4">
        <div class="container">
            <div class="row justify-content-center">

                <!-- Contenedor principal -->
                <div class="col-lg-8 col-md-10 col-12">
                    <div class="row g-4">
                        <!-- Lado izquierdo (espaciador en pantallas grandes) -->
                        <div class="col-lg-2 d-none d-lg-block"></div>

                        <!-- Contenido principal -->
                        <div class="col-lg-8 col-md-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <!-- Perfil -->
                                    <div class="text-center mb-4">
                                        <!-- Avatar con borde -->
                                        <form class="fotoPf d-flex flex-column align-items-center" method="post" enctype="multipart/form-data" action="./PHP/guardar_perfil.php">
                                            <input type="file" name="foto" id="imgChange" accept="image/*" style="display:none;" onchange="javascript:previewImage(event, '#imgPf')" required>
                                            <label for="imgChange">
                                                <img src="<?php $rutaImagen = str_replace('../', './', $row['perfil']); echo $rutaImagen; ?>"
                                                     alt="avatar"
                                                     class="rounded-circle img-fluid border border-2 border-success"
                                                     id="imgPf"
                                                     style="cursor: pointer; max-width: 150px;">
                                            </label>
                                            <!-- Botón debajo del avatar -->
                                            <button type="submit" class="btn btn-success mt-3">
                                                <i class="fas fa-upload me-2"></i> Actualizar Perfil
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Información del perfil -->
                                    <div class="text-center mb-4">
                                        <h5 class="fw-bold">
                                            <?php
                                            if (isset($row['nombre_usuario'])) {
                                                echo $row['nombre_usuario'];
                                            } else {
                                                echo "Nombre de usuario no encontrado.";
                                            }
                                            ?>
                                        </h5>
                                        <!-- Resaltando los puntos -->
                                        <p class="mb-1 text-warning fw-bold" style="font-size: 1.25rem;">
                                            <?php echo $row['puntos']; ?> pts.
                                        </p>
                                        <p class="mb-1 text-muted"><?php echo $row['correo']; ?></p>
                                    </div>

                                    <!-- Opciones -->
                                    <div class="d-flex justify-content-center">
                                        <!--<a href="javascript:abreConf()" class="btn btn-danger">
                                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                        </a>-->

                                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                            <i class="fas fa-sign-out-alt"></i>Cerrar Sesión
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lado derecho (espaciador en pantallas grandes) -->
                        <div class="col-lg-2 d-none d-lg-block"></div>
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

<script src="JS/preview.js"></script>

<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>-->

</body>

</html>