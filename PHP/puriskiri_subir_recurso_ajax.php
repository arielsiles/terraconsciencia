<?php
/**
 * Backend AJAX para subida de recursos PURISKIRI
 * Retorna respuestas JSON en lugar de redirecciones
 */
session_start();
include "conexionBe.php";

header('Content-Type: application/json');

/**
 * Función para enviar respuesta de error
 */
function responderError($codigo, $mensaje, $detalles = null) {
    echo json_encode([
        'success' => false,
        'codigo' => $codigo,
        'error' => $mensaje,
        'detalles' => $detalles
    ]);
    die();
}

/**
 * Función para enviar respuesta exitosa
 */
function responderExito($mensaje, $datos = []) {
    echo json_encode(array_merge([
        'success' => true,
        'mensaje' => $mensaje
    ], $datos));
    die();
}

// Verificar permisos
$roles_permitidos = ['Administrador', 'Docente'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    responderError('NO_AUTORIZADO', 'No tienes permisos para subir recursos.');
}

// Verificar que se envió el formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responderError('METODO_INVALIDO', 'Método no permitido.');
}

// Obtener datos del formulario
$titulo = isset($_POST['titulo']) ? mysqli_real_escape_string($conexion, trim($_POST['titulo'])) : '';
$descripcion = isset($_POST['descripcion']) ? mysqli_real_escape_string($conexion, trim($_POST['descripcion'])) : '';
$categoria_id = isset($_POST['categoria']) ? (int)$_POST['categoria'] : 0;
$nivel_id = isset($_POST['nivel']) ? (int)$_POST['nivel'] : 0;
$autor = isset($_POST['autor']) ? mysqli_real_escape_string($conexion, trim($_POST['autor'])) : '';
$palabras_clave = isset($_POST['palabras_clave']) ? mysqli_real_escape_string($conexion, trim($_POST['palabras_clave'])) : '';
$usuario_id = $_SESSION['id'];

// Validaciones básicas
if (empty($titulo)) {
    responderError('CAMPO_VACIO', 'El título es requerido.', ['campo' => 'titulo']);
}

if (empty($descripcion)) {
    responderError('CAMPO_VACIO', 'La descripción es requerida.', ['campo' => 'descripcion']);
}

if (strlen($descripcion) < 100) {
    responderError('DESCRIPCION_CORTA', 'La descripción debe tener al menos 100 caracteres.', [
        'campo' => 'descripcion',
        'actual' => strlen($descripcion),
        'minimo' => 100
    ]);
}

if ($categoria_id <= 0) {
    responderError('CAMPO_VACIO', 'Debes seleccionar un tema.', ['campo' => 'categoria']);
}

if ($nivel_id <= 0) {
    responderError('CAMPO_VACIO', 'Debes seleccionar un nivel educativo.', ['campo' => 'nivel']);
}

// Verificar archivo
if (!isset($_FILES['archivo'])) {
    responderError('ARCHIVO_FALTANTE', 'Debes seleccionar un archivo para subir.');
}

// Interpretar código de error del archivo
$error_archivo = $_FILES['archivo']['error'];
if ($error_archivo !== UPLOAD_ERR_OK) {
    $mensajes_error = [
        UPLOAD_ERR_INI_SIZE => 'El archivo excede el tamaño máximo permitido por el servidor.',
        UPLOAD_ERR_FORM_SIZE => 'El archivo excede el tamaño máximo del formulario.',
        UPLOAD_ERR_PARTIAL => 'El archivo se subió parcialmente. Por favor intenta de nuevo.',
        UPLOAD_ERR_NO_FILE => 'No se seleccionó ningún archivo.',
        UPLOAD_ERR_NO_TMP_DIR => 'Error del servidor: falta la carpeta temporal.',
        UPLOAD_ERR_CANT_WRITE => 'Error del servidor: no se pudo escribir el archivo.',
        UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la carga del archivo.'
    ];

    $mensaje = isset($mensajes_error[$error_archivo])
        ? $mensajes_error[$error_archivo]
        : 'Error desconocido al subir el archivo (código: ' . $error_archivo . ').';

    responderError('ERROR_SUBIDA', $mensaje, ['codigo_error' => $error_archivo]);
}

// Extensiones permitidas
$extensiones_permitidas = ['pdf', 'ppt', 'pptx', 'doc', 'docx', 'xlsx'];
$archivo_nombre = $_FILES['archivo']['name'];
$archivo_tmp = $_FILES['archivo']['tmp_name'];
$archivo_extension = strtolower(pathinfo($archivo_nombre, PATHINFO_EXTENSION));

if (!in_array($archivo_extension, $extensiones_permitidas)) {
    responderError('EXTENSION_INVALIDA', 'Tipo de archivo no permitido. Solo se aceptan: ' . implode(', ', array_map('strtoupper', $extensiones_permitidas)), [
        'extension' => $archivo_extension,
        'permitidas' => $extensiones_permitidas
    ]);
}

// Obtener límite de tamaño desde la configuración
$query_config = "SELECT valor FROM puriskiri_config WHERE clave = 'limite_archivo_mb'";
$result_config = mysqli_query($conexion, $query_config);
$limite_mb = 100; // Valor por defecto
if ($result_config && mysqli_num_rows($result_config) > 0) {
    $config_row = mysqli_fetch_assoc($result_config);
    $limite_mb = (int)$config_row['valor'];
}
$max_size = $limite_mb * 1024 * 1024;

// Verificar tamaño
$archivo_size = $_FILES['archivo']['size'];
if ($archivo_size > $max_size) {
    $size_mb = round($archivo_size / (1024 * 1024), 2);
    responderError('ARCHIVO_MUY_GRANDE', "El archivo ({$size_mb} MB) excede el límite de {$limite_mb} MB.", [
        'tamano_archivo_mb' => $size_mb,
        'limite_mb' => $limite_mb
    ]);
}

// Generar nombre único para el archivo
$timestamp = date('Ymd_His');
$unique_id = uniqid();
$nuevo_nombre_archivo = $timestamp . '_' . $unique_id . '.' . $archivo_extension;
$ruta_destino = "../PURISKIRI/documentos/" . $nuevo_nombre_archivo;
$ruta_bd = "PURISKIRI/documentos/" . $nuevo_nombre_archivo;

// Crear directorio si no existe
$dir_documentos = "../PURISKIRI/documentos/";
if (!is_dir($dir_documentos)) {
    mkdir($dir_documentos, 0755, true);
}

// Mover archivo
if (!move_uploaded_file($archivo_tmp, $ruta_destino)) {
    responderError('ERROR_MOVER', 'No se pudo guardar el archivo. Verifica los permisos del servidor.');
}

// Procesar portada (opcional)
$ruta_portada = '';
if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
    $portada_nombre = $_FILES['portada']['name'];
    $portada_tmp = $_FILES['portada']['tmp_name'];
    $portada_extension = strtolower(pathinfo($portada_nombre, PATHINFO_EXTENSION));

    $extensiones_imagen = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($portada_extension, $extensiones_imagen)) {
        // Verificar tamaño (5MB máximo)
        if ($_FILES['portada']['size'] <= 5 * 1024 * 1024) {
            $nuevo_nombre_portada = $timestamp . '_' . $unique_id . '_portada.' . $portada_extension;
            $dir_portadas = "../PURISKIRI/portadas/";
            if (!is_dir($dir_portadas)) {
                mkdir($dir_portadas, 0755, true);
            }
            $ruta_portada_destino = $dir_portadas . $nuevo_nombre_portada;
            $ruta_portada = "PURISKIRI/portadas/" . $nuevo_nombre_portada;

            if (!move_uploaded_file($portada_tmp, $ruta_portada_destino)) {
                $ruta_portada = '';
            }
        }
    }
}

// Determinar tipo de archivo para la BD
$tipo_archivo = $archivo_extension;

// Insertar en base de datos
$query = "INSERT INTO puriskiri_recursos (titulo, descripcion, categoria_id, nivel_id, tipo_archivo, ruta_archivo, ruta_portada, autor, palabras_clave, usuario_id, descargas, destacado, activo, fecha_creacion)
          VALUES ('$titulo', '$descripcion', $categoria_id, $nivel_id, '$tipo_archivo', '$ruta_bd', '$ruta_portada', '$autor', '$palabras_clave', $usuario_id, 0, 0, 1, NOW())";

if (mysqli_query($conexion, $query)) {
    $nuevo_id = mysqli_insert_id($conexion);
    responderExito('Recurso subido exitosamente.', [
        'id' => $nuevo_id,
        'titulo' => stripslashes($titulo)
    ]);
} else {
    // Si falla, eliminar archivos subidos
    if (file_exists($ruta_destino)) {
        unlink($ruta_destino);
    }
    if (!empty($ruta_portada) && file_exists("../" . $ruta_portada)) {
        unlink("../" . $ruta_portada);
    }
    responderError('ERROR_BD', 'Error al guardar en la base de datos. Intenta nuevamente.');
}
?>
