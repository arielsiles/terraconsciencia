<?php
include "conexionBe.php";

// Verificar la conexion a la base de datos
if ($conexion) {
    echo "Hay conexion";
} else {
    echo "No hay conexion";
}

session_start();

// Validar la existencia de $_SESSION['id'] y $_POST['puntos']
if (!isset($_SESSION['id']) || !isset($_POST['puntos'])) {
    die("Datos incompletos");
}

$usuarioId = $_SESSION['id'];
$puntos = intval($_POST['puntos']); // Asegurar que 'puntos' sea un entero

// Consulta preparada para evitar inyecci車n de SQL
$consulta = "SELECT contadorFV FROM usuarios WHERE id = ?";
$stmt = mysqli_prepare($conexion, $consulta);
mysqli_stmt_bind_param($stmt, "i", $usuarioId);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

// Manejo de errores para la consulta
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$fila = mysqli_fetch_assoc($resultado);
$contadorFV = $fila['contadorFV'];

if ($contadorFV > 0) {
    echo "Ya has respondido al formulario demasiadas veces.";
} else {
    // Consulta preparada para evitar inyecci車n de SQL
    $consultaActualizar = "UPDATE usuarios SET puntos = puntos + ?, contadorFV = 1 WHERE id = ?";
    $stmtActualizar = mysqli_prepare($conexion, $consultaActualizar);
    mysqli_stmt_bind_param($stmtActualizar, "ii", $puntos, $usuarioId);
    mysqli_stmt_execute($stmtActualizar);

    // Manejo de errores para la consulta de actualizaci車n
    if (!$stmtActualizar) {
        die("Error al actualizar la puntuaci車n: " . mysqli_error($conexion));
    }

    echo "La puntuaci車n se actualiz車 correctamente";
}

// Cerrar las consultas preparadas y la conexi車n
mysqli_stmt_close($stmt);
mysqli_stmt_close($stmtActualizar);
mysqli_close($conexion);
?>
