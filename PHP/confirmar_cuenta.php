<?php
/**
 * Confirmación de cuenta por token
 * Terra ConsCiencia
 */

include "conexionBe.php";
require_once "config_email.php";

$mensaje = '';
$exito = false;

if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = mysqli_real_escape_string($conexion, $_GET['token']);

    // Buscar usuario con este token
    $query = "SELECT id, nombre_usuario, token_expira FROM usuarios WHERE token_confirmacion = '$token' AND activo = 0";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Verificar si el token ha expirado
        $ahora = new DateTime();
        $expira = new DateTime($usuario['token_expira']);

        if ($ahora <= $expira) {
            // Token válido, activar cuenta
            $id_usuario = $usuario['id'];
            $queryUpdate = "UPDATE usuarios SET activo = 1, token_confirmacion = NULL, token_expira = NULL WHERE id = '$id_usuario'";

            if (mysqli_query($conexion, $queryUpdate)) {
                $exito = true;
                $mensaje = '¡Tu cuenta ha sido activada exitosamente!';
            } else {
                $mensaje = 'Error al activar la cuenta. Por favor, intenta nuevamente.';
            }
        } else {
            $mensaje = 'El enlace de confirmación ha expirado. Por favor, solicita uno nuevo.';
        }
    } else {
        $mensaje = 'El enlace de confirmación no es válido o la cuenta ya fue activada.';
    }
} else {
    $mensaje = 'Token de confirmación no proporcionado.';
}

mysqli_close($conexion);

// Redirigir a la página correspondiente
if ($exito) {
    header("location: ../cuenta_activada.php");
    exit();
} else {
    // Mostrar error con opción de reenviar
    header("location: ../confirmacion_pendiente.php?error=" . urlencode($mensaje));
    exit();
}
?>
