<?php
    include('conexionBe.php');
    
    $query = "SELECT ruta FROM img_ord";
    $resultado = mysqli_query($conexion, $query);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    $rutas = array();

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $rutas[] = $fila['ruta'];
    }

    mysqli_close($conexion);

    header('Content-Type: application/json');
    echo json_encode($rutas);
?>
