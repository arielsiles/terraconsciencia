<?php
header('Content-Type: text/html; charset=utf-8');
include './PHP/conexionBe.php';

$descripciones = array();

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Realizar la consulta
$sql = "SELECT descripcion FROM popups";

$resultado = $conexion->query($sql);

// Verificar si la consulta fue exitosa
if ($resultado) {
    // Obtener los datos
    while ($row = $resultado->fetch_assoc()) {
        $descripciones[] = $row["descripcion"];
    }
} else {
    // Mostrar un mensaje de error si la consulta falla
    echo "Error en la consulta: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>
