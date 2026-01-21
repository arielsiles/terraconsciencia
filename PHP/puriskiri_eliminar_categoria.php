<?php
session_start();

// Verificar permisos de administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: ../ConLogin.php");
    die();
}

include "conexionBe.php";

// Obtener parametros
$id = (int)($_GET['id'] ?? 0);
$accion = $_GET['accion'] ?? '';

// Validar datos
if ($id <= 0 || empty($accion)) {
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

switch ($accion) {
    case 'eliminar':
        // Contar recursos asociados
        $query_count = "SELECT COUNT(*) as total FROM puriskiri_recursos WHERE categoria_id = $id";
        $resultado_count = mysqli_query($conexion, $query_count);
        $total_recursos = mysqli_fetch_assoc($resultado_count)['total'];

        if ($total_recursos > 0) {
            // Tiene recursos asociados, solo inactivar
            $query = "UPDATE puriskiri_categorias SET activo = 0 WHERE id = $id";
            if (mysqli_query($conexion, $query)) {
                header("Location: ../PuriskiriCategoriasAdm.php?inactivada=1");
            } else {
                header("Location: ../PuriskiriCategoriasAdm.php?error=1");
            }
        } else {
            // No tiene recursos, eliminar completamente
            $query = "DELETE FROM puriskiri_categorias WHERE id = $id";
            if (mysqli_query($conexion, $query)) {
                header("Location: ../PuriskiriCategoriasAdm.php?eliminada=1");
            } else {
                header("Location: ../PuriskiriCategoriasAdm.php?error=1");
            }
        }
        break;

    case 'inactivar':
        $query = "UPDATE puriskiri_categorias SET activo = 0 WHERE id = $id";
        if (mysqli_query($conexion, $query)) {
            header("Location: ../PuriskiriCategoriasAdm.php?inactivada=1");
        } else {
            header("Location: ../PuriskiriCategoriasAdm.php?error=1");
        }
        break;

    case 'activar':
        $query = "UPDATE puriskiri_categorias SET activo = 1 WHERE id = $id";
        if (mysqli_query($conexion, $query)) {
            header("Location: ../PuriskiriCategoriasAdm.php?activada=1");
        } else {
            header("Location: ../PuriskiriCategoriasAdm.php?error=1");
        }
        break;

    default:
        header("Location: ../PuriskiriCategoriasAdm.php?error=1");
        break;
}

mysqli_close($conexion);
?>
