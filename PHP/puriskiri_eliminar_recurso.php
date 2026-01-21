<?php
session_start();
include "conexionBe.php";

// Verificar que el usuario esté autenticado
$roles_permitidos = ['Administrador', 'Docente'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: ../Puriskiri.php");
    die();
}

// Obtener ID del recurso
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$desde_admin = isset($_GET['admin']);

if ($id <= 0) {
    $redirect = $desde_admin ? '../PuriskiriAdm.php?error=1' : '../PuriskiriDescargar.php?error=1';
    header("Location: $redirect");
    die();
}

// Verificar que el recurso existe
$query = "SELECT * FROM puriskiri_recursos WHERE id = $id";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) == 0) {
    $redirect = $desde_admin ? '../PuriskiriAdm.php?error=2' : '../PuriskiriDescargar.php?error=2';
    header("Location: $redirect");
    die();
}

$recurso = mysqli_fetch_assoc($resultado);

// Verificar permisos: solo el propietario o admin pueden eliminar
if ($_SESSION['rol'] != 'Administrador' && $recurso['usuario_id'] != $_SESSION['id']) {
    $redirect = $desde_admin ? '../PuriskiriAdm.php?error=3' : '../PuriskiriDescargar.php?error=3';
    header("Location: $redirect");
    die();
}

// Eliminar archivos físicos
$ruta_archivo = "../" . $recurso['ruta_archivo'];
$ruta_portada = !empty($recurso['ruta_portada']) ? "../" . $recurso['ruta_portada'] : '';

if (file_exists($ruta_archivo)) {
    unlink($ruta_archivo);
}

if (!empty($ruta_portada) && file_exists($ruta_portada)) {
    unlink($ruta_portada);
}

// Eliminar de la base de datos
$query_delete = "DELETE FROM puriskiri_recursos WHERE id = $id";

if (mysqli_query($conexion, $query_delete)) {
    $redirect = $desde_admin ? '../PuriskiriAdm.php?eliminado=1' : '../PuriskiriDescargar.php?eliminado=1';
    header("Location: $redirect");
} else {
    $redirect = $desde_admin ? '../PuriskiriAdm.php?error=4' : '../PuriskiriDescargar.php?error=4';
    header("Location: $redirect");
}
?>
