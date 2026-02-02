<?php
/**
 * Reenvío de correo de confirmación
 * Terra ConsCiencia
 */

include "conexionBe.php";
require_once "config_email.php";
require_once "enviar_correo.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: ../SinLogin.php");
    exit();
}

$correo = isset($_POST['email']) ? trim($_POST['email']) : '';

if (empty($correo)) {
    header("location: ../confirmacion_pendiente.php?error=" . urlencode("Por favor proporciona un correo electrónico."));
    exit();
}

$correo_escaped = mysqli_real_escape_string($conexion, $correo);

// Buscar usuario con este correo que no esté activado
$query = "SELECT id, nombre_usuario FROM usuarios WHERE correo = '$correo_escaped' AND activo = 0";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) == 0) {
    // El usuario no existe o ya está activado
    header("location: ../confirmacion_pendiente.php?error=" . urlencode("No se encontró una cuenta pendiente de activación con ese correo.") . "&email=" . urlencode($correo));
    exit();
}

$usuario = mysqli_fetch_assoc($resultado);
$id_usuario = $usuario['id'];
$nombre_usuario = $usuario['nombre_usuario'];

// Generar nuevo token
$token = generarToken();
$token_expira = calcularExpiracionToken();
$token_escaped = mysqli_real_escape_string($conexion, $token);

// Actualizar token en la base de datos
$queryUpdate = "UPDATE usuarios SET token_confirmacion = '$token_escaped', token_expira = '$token_expira' WHERE id = '$id_usuario'";

if (!mysqli_query($conexion, $queryUpdate)) {
    header("location: ../confirmacion_pendiente.php?error=" . urlencode("Error al generar nuevo enlace. Intenta nuevamente.") . "&email=" . urlencode($correo));
    exit();
}

// Enviar nuevo correo
$resultadoEmail = enviarCorreoConfirmacion($correo, $nombre_usuario, $token);

if ($resultadoEmail['success']) {
    header("location: ../confirmacion_pendiente.php?reenviado=1&email=" . urlencode($correo));
} else {
    header("location: ../confirmacion_pendiente.php?error=" . urlencode("Error al enviar el correo. Intenta nuevamente.") . "&email=" . urlencode($correo));
}

mysqli_close($conexion);
exit();
?>
