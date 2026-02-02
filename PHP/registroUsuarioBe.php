<?php

include "conexionBe.php";
require_once "config_email.php";
require_once "enviar_correo.php";

$nombre_usuario = $_POST["nombre_usuario"];
$correo = $_POST["correo"];
$clave = $_POST["clave"];
$institucion = isset($_POST["institucion"]) ? trim($_POST["institucion"]) : '';
$rol_id = 2;

// Validar reCAPTCHA si está configurado
if (defined('RECAPTCHA_SECRET_KEY') && RECAPTCHA_SECRET_KEY !== 'tu_secret_key_aqui') {
    $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

    if (empty($recaptcha_response)) {
        echo'
            <script>
                alert("Por favor completa el captcha");
                window.location = "../SinLogin.php"
            </script>
        ';
        exit();
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
        echo'
            <script>
                alert("Verificacion de captcha fallida. Intente nuevamente.");
                window.location = "../SinLogin.php"
            </script>
        ';
        exit();
    }
}

$clave = hash('sha512', $clave);

$verificarCr = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' ");

if(mysqli_num_rows($verificarCr) > 0){
    echo'
        <script>
            alert("Correo ya registrado, pruebe uno distinto");
            window.location = "../SinLogin.php"
        </script>
    ';
    exit();
}

$verificarUsr = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nombre_usuario='$nombre_usuario' ");

if(mysqli_num_rows($verificarUsr) > 0){
    echo'
        <script>
            alert("Nombre de Usuario ya registrado, pruebe uno distinto");
            window.location = "../SinLogin.php"
        </script>
    ';
    exit();
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
    $institucion_escaped = mysqli_real_escape_string($conexion, $institucion);
    $token_escaped = mysqli_real_escape_string($conexion, $token);

    // Insertar usuario con activo=0 y token de confirmación
    $query2 = "INSERT INTO usuarios(id, nombre_usuario, correo, clave, rol_id, activo, token_confirmacion, token_expira, institucion)
               VALUES('$id_perfil', '$nombre_usuario_escaped', '$correo_escaped', '$clave', '$rol_id', 0, '$token_escaped', '$token_expira', '$institucion_escaped')";
    mysqli_query($conexion, $query2);

    // Enviar correo de confirmación
    $resultadoEmail = enviarCorreoConfirmacion($correo, $nombre_usuario, $token);

    if (!$resultadoEmail['success']) {
        // Si falla el envío del email, hacer rollback
        throw new Exception("Error al enviar correo de confirmación: " . $resultadoEmail['message']);
    }

    mysqli_commit($conexion);

    // Redirigir a página de confirmación pendiente
    header("location: ../confirmacion_pendiente.php?email=" . urlencode($correo));
    exit();

} catch (mysqli_sql_exception $e) {
    mysqli_rollback($conexion);
    echo "Error en la consulta SQL: " . mysqli_error($conexion);
} catch (Exception $e) {
    mysqli_rollback($conexion);

    echo'
        <script>
            alert("Error al procesar el registro. Por favor, intente nuevamente.");
            window.location = "../SinLogin.php"
        </script>
       ';
}

mysqli_close($conexion);
?>
