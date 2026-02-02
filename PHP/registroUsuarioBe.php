<?php

include "conexionBe.php";
require_once "config_email.php";
require_once "enviar_correo.php";

// Detectar si es petición AJAX
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Función para responder (JSON si es AJAX, script si no)
function responder($success, $message, $redirect = null) {
    global $isAjax;

    if ($isAjax) {
        header('Content-Type: application/json');
        $response = ['success' => $success, 'message' => $message];
        if ($redirect) {
            $response['redirect'] = $redirect;
        }
        echo json_encode($response);
        exit();
    } else {
        // Fallback para navegadores sin JavaScript
        if ($success && $redirect) {
            header("location: " . $redirect);
            exit();
        } else {
            echo '<script>alert("' . addslashes($message) . '"); window.location = "../SinLogin.php";</script>';
            exit();
        }
    }
}

// Función para validar contraseña
function validarContrasena($clave) {
    $errores = [];

    if (strlen($clave) < 8) {
        $errores[] = 'mínimo 8 caracteres';
    }
    if (!preg_match('/[A-Z]/', $clave)) {
        $errores[] = 'al menos una mayúscula';
    }
    if (!preg_match('/[a-z]/', $clave)) {
        $errores[] = 'al menos una minúscula';
    }
    if (!preg_match('/[0-9]/', $clave)) {
        $errores[] = 'al menos un número';
    }

    return $errores;
}

// Función para validar nombre de usuario
function validarNombreUsuario($nombre) {
    $errores = [];

    if (strlen($nombre) < 3) {
        $errores[] = 'mínimo 3 caracteres';
    }
    if (strlen($nombre) > 20) {
        $errores[] = 'máximo 20 caracteres';
    }
    if (!preg_match('/^[a-z0-9]+$/', $nombre)) {
        $errores[] = 'solo letras minúsculas y números';
    }

    return $errores;
}

$nombre_usuario = strtolower(trim($_POST["nombre_usuario"]));
$correo = $_POST["correo"];
$clave = $_POST["clave"];
$nombre_completo = isset($_POST["nombre_completo"]) ? trim($_POST["nombre_completo"]) : '';
$institucion = isset($_POST["institucion"]) ? trim($_POST["institucion"]) : '';
$rol_id = 2;

// Validar nombre de usuario
$erroresUsername = validarNombreUsuario($nombre_usuario);
if (!empty($erroresUsername)) {
    responder(false, "El nombre de usuario debe tener: " . implode(', ', $erroresUsername));
}

// Validar nombre completo
if (empty($nombre_completo)) {
    responder(false, "El nombre completo es requerido");
}

// Validar institución
if (empty($institucion)) {
    responder(false, "La institución es requerida");
}

// Validar contraseña
$erroresPassword = validarContrasena($clave);
if (!empty($erroresPassword)) {
    responder(false, "La contraseña debe tener: " . implode(', ', $erroresPassword));
}

// Validar reCAPTCHA si está configurado
if (defined('RECAPTCHA_SECRET_KEY') && RECAPTCHA_SECRET_KEY !== 'tu_secret_key_aqui') {
    $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

    if (empty($recaptcha_response)) {
        responder(false, "Por favor completa el captcha");
    }

    // Verificar con la API de Google
    $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => RECAPTCHA_SECRET_KEY,
        'response' => $recaptcha_response,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $verify_response = file_get_contents($verify_url, false, $context);
    $response_data = json_decode($verify_response);

    if (!$response_data->success) {
        responder(false, "Verificación de captcha fallida. Intente nuevamente.");
    }
}

$clave = hash('sha512', $clave);

$verificarCr = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' ");

if(mysqli_num_rows($verificarCr) > 0){
    responder(false, "Correo ya registrado, pruebe uno distinto");
}

$verificarUsr = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nombre_usuario='$nombre_usuario' ");

if(mysqli_num_rows($verificarUsr) > 0){
    responder(false, "Nombre de usuario ya registrado, pruebe uno distinto");
}

// Generar token de confirmación
$token = generarToken();
$token_expira = calcularExpiracionToken();

mysqli_begin_transaction($conexion);

try {
    $query1 = "INSERT INTO perfil() VALUES()";
    mysqli_query($conexion, $query1);

    $id_perfil = mysqli_insert_id($conexion);

    // Escapar valores para prevenir problemas con caracteres especiales
    $nombre_usuario_escaped = mysqli_real_escape_string($conexion, $nombre_usuario);
    $correo_escaped = mysqli_real_escape_string($conexion, $correo);
    $nombre_completo_escaped = mysqli_real_escape_string($conexion, $nombre_completo);
    $institucion_escaped = mysqli_real_escape_string($conexion, $institucion);
    $token_escaped = mysqli_real_escape_string($conexion, $token);

    // Insertar usuario con activo=0 y token de confirmación
    $query2 = "INSERT INTO usuarios(id, nombre_usuario, nombre_completo, correo, clave, rol_id, activo, token_confirmacion, token_expira, institucion)
               VALUES('$id_perfil', '$nombre_usuario_escaped', '$nombre_completo_escaped', '$correo_escaped', '$clave', '$rol_id', 0, '$token_escaped', '$token_expira', '$institucion_escaped')";
    mysqli_query($conexion, $query2);

    // Enviar correo de confirmación
    $resultadoEmail = enviarCorreoConfirmacion($correo, $nombre_usuario, $token);

    if (!$resultadoEmail['success']) {
        // Si falla el envío del email, hacer rollback y mostrar error específico
        mysqli_rollback($conexion);
        responder(false, "Error de correo: " . $resultadoEmail['message'] . ". Contacte al administrador.");
    }

    mysqli_commit($conexion);

    // Responder con éxito
    $redirect_url = "confirmacion_pendiente.php?email=" . urlencode($correo);
    responder(true, "Registro exitoso. Redirigiendo...", $redirect_url);

} catch (mysqli_sql_exception $e) {
    mysqli_rollback($conexion);
    responder(false, "Error en el registro. Por favor, intente nuevamente.");
} catch (Exception $e) {
    mysqli_rollback($conexion);
    responder(false, "Error al procesar el registro. Por favor, intente nuevamente.");
}

mysqli_close($conexion);
?>
