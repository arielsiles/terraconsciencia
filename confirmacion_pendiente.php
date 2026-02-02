<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    $email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
    $error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
    $reenviado = isset($_GET['reenviado']) ? true : false;
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Confirma tu cuenta - Terra ConsCiencia">
    <meta name="author" content="">

    <title>Confirma tu correo - Terra ConsCiencia</title>

    <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">

    <style>
        .confirmation-container {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .confirmation-card {
            max-width: 500px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 40px;
            text-align: center;
        }
        .confirmation-icon {
            font-size: 80px;
            color: #198754;
            margin-bottom: 20px;
        }
        .confirmation-icon.error {
            color: #dc3545;
        }
        .email-display {
            background: #f8f9fa;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            color: #198754;
            display: inline-block;
            margin: 15px 0;
        }
        .resend-form {
            margin-top: 20px;
        }
    </style>
</head>

<body>

<?php include 'header_info.php'; ?>

<!-- Menu -->
<?php include 'main_menu.php'; ?>

<main>
    <section class="confirmation-container section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="confirmation-card mx-auto">
                        <?php if (!empty($error)): ?>
                            <i class="bi bi-exclamation-circle confirmation-icon error"></i>
                            <h2>Hubo un problema</h2>
                            <p class="text-muted"><?php echo $error; ?></p>

                            <?php if (!empty($email)): ?>
                            <form action="PHP/reenviar_confirmacion.php" method="POST" class="resend-form">
                                <input type="hidden" name="email" value="<?php echo $email; ?>">
                                <p class="mt-3">¿Necesitas un nuevo enlace?</p>
                                <button type="submit" class="custom-btn">Reenviar correo de confirmación</button>
                            </form>
                            <?php endif; ?>

                        <?php elseif ($reenviado): ?>
                            <i class="bi bi-check-circle confirmation-icon"></i>
                            <h2>¡Correo reenviado!</h2>
                            <p class="text-muted">Hemos enviado un nuevo enlace de confirmación a:</p>
                            <?php if (!empty($email)): ?>
                            <div class="email-display"><?php echo $email; ?></div>
                            <?php endif; ?>
                            <p class="text-muted mt-3">Revisa tu bandeja de entrada y también la carpeta de spam.</p>

                        <?php else: ?>
                            <i class="bi bi-envelope-check confirmation-icon"></i>
                            <h2>¡Revisa tu correo!</h2>
                            <p class="text-muted">Hemos enviado un enlace de confirmación a:</p>
                            <?php if (!empty($email)): ?>
                            <div class="email-display"><?php echo $email; ?></div>
                            <?php endif; ?>
                            <p class="text-muted mt-3">
                                Haz clic en el enlace del correo para activar tu cuenta.
                                El enlace expira en 24 horas.
                            </p>

                            <hr class="my-4">

                            <p class="text-muted small">
                                ¿No recibiste el correo? Revisa tu carpeta de spam o
                            </p>
                            <form action="PHP/reenviar_confirmacion.php" method="POST" class="resend-form">
                                <input type="hidden" name="email" value="<?php echo $email; ?>">
                                <button type="submit" class="btn btn-outline-success">Reenviar correo</button>
                            </form>
                        <?php endif; ?>

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
