<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    header("Access-Control-Allow-Credentials: true");
    include 'conexionBe.php';

    $mensajesPrevios = array();
    $mensajesBuenos = array();
    $mensajesMalos = array();

    $sql = "SELECT mensajesPrevios, mensajesBuenos, mensajesMalos FROM juego_avion";
    $resultado = $conexion->query($sql);

    if ($resultado === false) {
        $error = 'Error en la consulta SQL: ' . mysqli_error($conexion);
        $data = array('error' => $error);
    } else {
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $mensajesPrevios[] = $fila['mensajesPrevios'];
                $mensajesBuenos[] = $fila['mensajesBuenos'];
                $mensajesMalos[] = $fila['mensajesMalos'];
            }
        }
        $data = array(
            'mensajesPrevios' => $mensajesPrevios,
            'mensajesBuenos' => $mensajesBuenos,
            'mensajesMalos' => $mensajesMalos
        );
    }
    $conexion->close();
    header('Content-Type: application/json');
    echo json_encode($data);
?>