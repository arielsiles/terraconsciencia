<?php
    include "conexionBe.php";
    session_start();
    $usuarioId = $_SESSION['id'];
    $puntos = $_POST['puntos'];
    $consulta = "SELECT contadorPlb FROM usuarios WHERE id = '$usuarioId'";
    $resultado = mysqli_query($conexion, $consulta);
    $fila = mysqli_fetch_assoc($resultado);
    $contadorPlb = $fila['contadorPlb'];
    if ($contadorPlb > 0) {
        echo "Ya has respondido al formulario demasiadas veces.";
    } else {
        $consulta = "UPDATE usuarios SET puntos = puntos + $puntos, contadorPlb = 1 WHERE id = '$usuarioId'";
        mysqli_query($conexion, $consulta);
        echo "La puntuación se actualizó correctamente";
    }
    mysqli_close($conexion);
?>
