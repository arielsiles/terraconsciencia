<?php
session_start();
include "conexionBe.php";

// Solo admin puede usar estas acciones rápidas
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Administrador') {
    header("Location: ../Puriskiri.php");
    die();
}

// Obtener parámetros
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

if ($id <= 0 || empty($accion)) {
    header("Location: ../PuriskiriAdm.php?error=1");
    die();
}

// Verificar que el recurso existe
$query = "SELECT * FROM puriskiri_recursos WHERE id = $id";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) == 0) {
    header("Location: ../PuriskiriAdm.php?error=2");
    die();
}

// Ejecutar acción
switch ($accion) {
    case 'destacado':
        $query_update = "UPDATE puriskiri_recursos SET destacado = 1 WHERE id = $id";
        $redirect_param = 'destacado=1';
        break;

    case 'nodestacado':
        $query_update = "UPDATE puriskiri_recursos SET destacado = 0 WHERE id = $id";
        $redirect_param = 'nodestacado=1';
        break;

    case 'activar':
        $query_update = "UPDATE puriskiri_recursos SET activo = 1 WHERE id = $id";
        $redirect_param = 'activado=1';
        break;

    case 'desactivar':
        $query_update = "UPDATE puriskiri_recursos SET activo = 0 WHERE id = $id";
        $redirect_param = 'desactivado=1';
        break;

    default:
        header("Location: ../PuriskiriAdm.php?error=3");
        die();
}

if (mysqli_query($conexion, $query_update)) {
    header("Location: ../PuriskiriAdm.php?$redirect_param");
} else {
    header("Location: ../PuriskiriAdm.php?error=4");
}
?>
