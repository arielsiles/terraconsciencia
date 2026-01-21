<?php
session_start();
include "conexionBe.php";

// Verificar permisos
$roles_permitidos = ['Administrador', 'Docente'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: ../Puriskiri.php");
    die();
}

// Verificar que se envió el formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../PuriskiriSubir.php?error=1");
    die();
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
if (empty($titulo) || empty($descripcion) || $categoria_id <= 0 || $nivel_id <= 0) {
    header("Location: ../PuriskiriSubir.php?error=campos");
    die();
}

if (strlen($descripcion) < 100) {
    header("Location: ../PuriskiriSubir.php?error=descripcion");
    die();
}

// Verificar archivo
if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
    header("Location: ../PuriskiriSubir.php?error=archivo");
    die();
}

// Extensiones permitidas
$extensiones_permitidas = ['pdf', 'ppt', 'pptx', 'doc', 'docx', 'xlsx'];
$archivo_nombre = $_FILES['archivo']['name'];
$archivo_tmp = $_FILES['archivo']['tmp_name'];
$archivo_extension = strtolower(pathinfo($archivo_nombre, PATHINFO_EXTENSION));

if (!in_array($archivo_extension, $extensiones_permitidas)) {
    header("Location: ../PuriskiriSubir.php?error=extension");
    die();
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
if ($_FILES['archivo']['size'] > $max_size) {
    header("Location: ../PuriskiriSubir.php?error=tamano&limite=" . $limite_mb);
    die();
}

// Generar nombre único para el archivo
$timestamp = date('Ymd_His');
$unique_id = uniqid();
$nuevo_nombre_archivo = $timestamp . '_' . $unique_id . '.' . $archivo_extension;
$ruta_destino = "../PURISKIRI/documentos/" . $nuevo_nombre_archivo;
$ruta_bd = "PURISKIRI/documentos/" . $nuevo_nombre_archivo;

// Mover archivo
if (!move_uploaded_file($archivo_tmp, $ruta_destino)) {
    header("Location: ../PuriskiriSubir.php?error=upload");
    die();
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
            $ruta_portada_destino = "../PURISKIRI/portadas/" . $nuevo_nombre_portada;
            $ruta_portada = "PURISKIRI/portadas/" . $nuevo_nombre_portada;

            if (!move_uploaded_file($portada_tmp, $ruta_portada_destino)) {
                $ruta_portada = '';
            }
        }
    }
}

// Determinar tipo de archivo para la BD
$tipo_archivo = $archivo_extension;
if ($tipo_archivo == 'pptx') $tipo_archivo = 'pptx';
if ($tipo_archivo == 'docx') $tipo_archivo = 'docx';

// Insertar en base de datos
$query = "INSERT INTO puriskiri_recursos (titulo, descripcion, categoria_id, nivel_id, tipo_archivo, ruta_archivo, ruta_portada, autor, palabras_clave, usuario_id, descargas, destacado, activo, fecha_creacion)
          VALUES ('$titulo', '$descripcion', $categoria_id, $nivel_id, '$tipo_archivo', '$ruta_bd', '$ruta_portada', '$autor', '$palabras_clave', $usuario_id, 0, 0, 1, NOW())";

if (mysqli_query($conexion, $query)) {
    header("Location: ../PuriskiriSubir.php?exito=1");
} else {
    // Si falla, eliminar archivos subidos
    if (file_exists($ruta_destino)) {
        unlink($ruta_destino);
    }
    if (!empty($ruta_portada) && file_exists("../" . $ruta_portada)) {
        unlink("../" . $ruta_portada);
    }
    header("Location: ../PuriskiriSubir.php?error=db");
}
?>
