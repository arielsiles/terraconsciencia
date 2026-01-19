<?php
session_start();

// Verificar permisos de administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: ../ConLogin.php");
    die();
}

// Verificar que sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
    die();
}

include "conexionBe.php";

// Obtener y sanitizar datos
$id = (int)($_POST['id'] ?? 0);
$nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre'] ?? ''));
$slug = mysqli_real_escape_string($conexion, trim($_POST['slug'] ?? ''));
$descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion'] ?? ''));
$orden = (int)($_POST['orden'] ?? 0);

// Validar datos requeridos
if ($id <= 0 || empty($nombre) || empty($slug)) {
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
    die();
}

// Validar formato del slug (solo minusculas, numeros y guiones)
if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
    die();
}

// Verificar que la categoria existe
$query_exists = "SELECT id FROM puriskiri_categorias WHERE id = $id";
$resultado_exists = mysqli_query($conexion, $query_exists);

if (mysqli_num_rows($resultado_exists) == 0) {
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
    die();
}

// Verificar que no exista otra categoria con el mismo nombre o slug
$query_check = "SELECT id FROM puriskiri_categorias WHERE (nombre = '$nombre' OR slug = '$slug') AND id != $id";
$resultado_check = mysqli_query($conexion, $query_check);

if (mysqli_num_rows($resultado_check) > 0) {
    header("Location: ../PuriskiriCategoriasAdm.php?error_duplicado=1");
    die();
}

// Actualizar categoria
$query = "UPDATE puriskiri_categorias
    SET nombre = '$nombre',
        slug = '$slug',
        descripcion = '$descripcion',
        orden = $orden
    WHERE id = $id";

if (mysqli_query($conexion, $query)) {
    header("Location: ../PuriskiriCategoriasAdm.php?editada=1");
} else {
    header("Location: ../PuriskiriCategoriasAdm.php?error=1");
}

mysqli_close($conexion);
?>
