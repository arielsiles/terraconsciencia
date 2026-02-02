<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Cuenta activada - Terra ConsCiencia">
    <meta name="author" content="">

    <title>Cuenta Activada - Terra ConsCiencia</title>

    <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

    <style>
        .success-container {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-card {
            max-width: 500px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 40px;
            text-align: center;
        }
        .success-icon {
            font-size: 100px;
            color: #198754;
            margin-bottom: 20px;
            animation: scaleIn 0.5s ease-out;
        }
        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        .success-title {
            color: #198754;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<?php include 'header_info.php'; ?>

<?php include 'modal_iniciar.php'; ?>

<!-- Menu -->
<?php include 'main_menu.php'; ?>

<main>
    <section class="success-container section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="success-card mx-auto">
                        <i class="bi bi-check-circle-fill success-icon"></i>
                        <h2 class="success-title">¡Cuenta Activada!</h2>
                        <p class="text-muted">
                            Tu cuenta ha sido verificada exitosamente.
                            Ya puedes iniciar sesión y acceder a todo el contenido de Terra ConsCiencia.
                        </p>

                        <div class="mt-4">
                            <a href="#" class="custom-btn" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Iniciar Sesión
                            </a>
                        </div>

                        <div class="mt-4">
                            <a href="SinLogin.php" class="text-muted">← Volver al inicio</a>
                        </div>
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
<script src="JS/custom.js"></script>

</body>
</html>
