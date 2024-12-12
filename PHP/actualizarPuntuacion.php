<?php
include "conexionBe.php";
session_start();
$usuarioId = $_SESSION['id'];
$puntuacion = $_POST['puntuacion'];
$contador = 0;
$query = "SELECT contador FROM usuarios WHERE id = '$usuarioId'";
$resultado = mysqli_query($conexion, $query);
$fila = mysqli_fetch_assoc($resultado);
$contador = $fila['contador'];
if ($contador > 0) {
    echo "Has respondido al formulario demasiadas veces.";
} else {
    $consulta = "SELECT puntos FROM usuarios WHERE id = '$usuarioId'";
    $resultado = mysqli_query($conexion, $consulta);
    $fila = mysqli_fetch_assoc($resultado);
    $puntosTotales = $fila['puntos'];
    $puntosTotales += $puntuacion;
    $consulta = "UPDATE usuarios SET contador = 1 , puntos = '$puntosTotales' WHERE id = '$usuarioId'";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        echo "La puntuación se actualizó correctamente";
    } else {
        echo "Hubo un error al actualizar la puntuación";
    }
}
?>