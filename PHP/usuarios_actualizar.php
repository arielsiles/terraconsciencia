<?php
session_start();

// Solo administradores pueden ejecutar estas acciones
$roles_permitidos = ['Administrador'];
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
    header("Location: ../ConLogin.php");
    die();
}

include "conexionBe.php";

// Validar parámetros
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

if ($id <= 0 || empty($accion)) {
    header("Location: ../UsuariosAdm.php?error=parametros");
    die();
}

// Obtener ID del usuario actual en sesión
$usuario_actual = $_SESSION['usuario'];
$query_actual = "SELECT id FROM usuarios WHERE nombre_usuario = '$usuario_actual'";
$resultado_actual = mysqli_query($conexion, $query_actual);
$usuario_actual_id = 0;
if ($resultado_actual && mysqli_num_rows($resultado_actual) > 0) {
    $usuario_actual_id = mysqli_fetch_assoc($resultado_actual)['id'];
}

// Validar que no se modifique a sí mismo en acciones críticas
if ($id == $usuario_actual_id && in_array($accion, ['desactivar', 'rol_usuario'])) {
    header("Location: ../UsuariosAdm.php?error=automodificacion");
    die();
}

// Procesar acción
$redireccion = "../UsuariosAdm.php";
$exito = false;

switch ($accion) {
    case 'activar':
        $query = "UPDATE usuarios SET activo = 1 WHERE id = $id";
        $resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            $redireccion .= "?activado=1";
            $exito = true;
        }
        break;

    case 'desactivar':
        $query = "UPDATE usuarios SET activo = 0 WHERE id = $id";
        $resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            $redireccion .= "?desactivado=1";
            $exito = true;
        }
        break;

    case 'rol_admin':
        // Obtener ID del rol Administrador
        $query_rol = "SELECT id FROM cargo WHERE descripcion = 'Administrador'";
        $resultado_rol = mysqli_query($conexion, $query_rol);
        if ($resultado_rol && mysqli_num_rows($resultado_rol) > 0) {
            $rol_id = mysqli_fetch_assoc($resultado_rol)['id'];
            $query = "UPDATE usuarios SET rol_id = $rol_id WHERE id = $id";
            $resultado = mysqli_query($conexion, $query);
            if ($resultado) {
                $redireccion .= "?rol_cambiado=admin";
                $exito = true;
            }
        }
        break;

    case 'rol_usuario':
        // Obtener ID del rol Usuario
        $query_rol = "SELECT id FROM cargo WHERE descripcion = 'Usuario'";
        $resultado_rol = mysqli_query($conexion, $query_rol);
        if ($resultado_rol && mysqli_num_rows($resultado_rol) > 0) {
            $rol_id = mysqli_fetch_assoc($resultado_rol)['id'];
            $query = "UPDATE usuarios SET rol_id = $rol_id WHERE id = $id";
            $resultado = mysqli_query($conexion, $query);
            if ($resultado) {
                $redireccion .= "?rol_cambiado=usuario";
                $exito = true;
            }
        }
        break;

    default:
        $redireccion .= "?error=accion_invalida";
        break;
}

if (!$exito && strpos($redireccion, '?') === false) {
    $redireccion .= "?error=db";
}

mysqli_close($conexion);
header("Location: $redireccion");
die();
