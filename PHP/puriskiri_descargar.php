<?php
session_start();
include "conexionBe.php";

// Verificar que el usuario esté autenticado
$roles_permitidos = ['Administrador', 'Docente', 'Usuario'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: ../SinLogin.php");
    die();
}

// Obtener ID del recurso
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: ../PuriskiriDescargar.php?error=1");
    die();
}

// Obtener información del recurso
$query = "SELECT * FROM puriskiri_recursos WHERE id = $id AND activo = 1";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) == 0) {
    header("Location: ../PuriskiriDescargar.php?error=2");
    die();
}

$recurso = mysqli_fetch_assoc($resultado);

// Ruta del archivo
$ruta_archivo = "../" . $recurso['ruta_archivo'];

// Verificar que el archivo existe
if (!file_exists($ruta_archivo)) {
    header("Location: ../PuriskiriDescargar.php?error=3");
    die();
}

// Incrementar contador de descargas
$query_update = "UPDATE puriskiri_recursos SET descargas = descargas + 1 WHERE id = $id";
mysqli_query($conexion, $query_update);

// Determinar el tipo MIME
$extension = strtolower(pathinfo($recurso['ruta_archivo'], PATHINFO_EXTENSION));
$mime_types = [
    'pdf' => 'application/pdf',
    'ppt' => 'application/vnd.ms-powerpoint',
    'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

$mime = isset($mime_types[$extension]) ? $mime_types[$extension] : 'application/octet-stream';

// Nombre del archivo para la descarga
$nombre_descarga = preg_replace('/[^a-zA-Z0-9_-]/', '_', $recurso['titulo']) . '.' . $extension;

// Enviar headers para descarga
header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . $nombre_descarga . '"');
header('Content-Length: ' . filesize($ruta_archivo));
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Enviar archivo
readfile($ruta_archivo);
exit;
?>
