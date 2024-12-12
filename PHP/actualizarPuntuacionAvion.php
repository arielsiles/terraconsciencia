<?php
    include "conexionBe.php";
    session_start();
    $usuarioId = $_SESSION['id'];
    $puntos = $_POST['puntuacion'];
    $consulta = "SELECT contadorAv FROM usuarios WHERE id = '$usuarioId'";
    $resultado = mysqli_query($conexion, $consulta);
    $fila = mysqli_fetch_assoc($resultado);
    $contadorFV = $fila['contadorAv'];
    if ($contadorFV > 2) {
        echo "Ya has respondido al formulario demasiadas veces.";
    } else {
        $contadorFV = $contadorFV + 1;
        $consulta = "UPDATE usuarios SET puntos = puntos + $puntos, contadorAv = '$contadorFV' WHERE id = '$usuarioId'";
        mysqli_query($conexion, $consulta);
        echo "La puntuación se actualizó correctamente";
    }
    mysqli_close($conexion);
?>
