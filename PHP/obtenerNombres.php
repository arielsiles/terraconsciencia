<?php
include('conexionBe.php');

// Ahora, obtén los nombres de los contenedores desde la base de datos
$idContenedor = 7; // El ID de la fila que contiene los nombres de los contenedores

$queryNombres = "SELECT titulo, pregunta FROM falsoverdadero WHERE id = $idContenedor";
$resultadoNombres = mysqli_query($conexion, $queryNombres);

if (!$resultadoNombres) {
    die("Error en la consulta de nombres: " . mysqli_error($conexion));
}

if ($filaNombres = mysqli_fetch_assoc($resultadoNombres)) {
    $nombreContenedorRojo = $filaNombres['titulo'];
    $nombreContenedorAzul = $filaNombres['pregunta'];
}

mysqli_close($conexion);

$respuesta = array(
    "nombreContenedorRojo" => $nombreContenedorRojo,
    "nombreContenedorAzul" => $nombreContenedorAzul
);

header('Content-Type: application/json');
echo json_encode($respuesta);
?>
