<?php
include "conexionBe.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['titAf']) && isset($_POST['contAf']) && isset($_POST['af1']) && isset($_POST['r1']) && isset($_POST['af2']) && isset($_POST['r2']) && isset($_POST['af3']) && isset($_POST['r3']) && isset($_POST['af4']) && isset($_POST['r4']) && isset($_POST['af5']) && isset($_POST['r5'])) {
        $titulo = $_POST['titAf'];
        $contenido = $_POST['contAf'];
        $af1 = $_POST['af1'];
        $r1 = $_POST['r1'];
        $af2 = $_POST['af2'];
        $r2 = $_POST['r2'];
        $af3 = $_POST['af3'];
        $r3 = $_POST['r3'];
        $af4 = $_POST['af4'];
        $r4 = $_POST['r4'];
        $af5 = $_POST['af5'];
        $r5 = $_POST['r5'];

        $sql = "UPDATE falsoverdadero SET titulo = '$titulo', pregunta = '$contenido' WHERE id=6";
        $sql2 = "UPDATE falsoverdadero SET pregunta = '$af1', fov = '$r1' WHERE id = 1";
        $sql3 = "UPDATE falsoverdadero SET pregunta = '$af2', fov = '$r2' WHERE id = 2";
        $sql4 = "UPDATE falsoverdadero SET pregunta = '$af3', fov = '$r3' WHERE id = 3";
        $sql5 = "UPDATE falsoverdadero SET pregunta = '$af4', fov = '$r4' WHERE id = 4";
        $sql6 = "UPDATE falsoverdadero SET pregunta = '$af5', fov = '$r5' WHERE id = 5";

        if (mysqli_query($conexion, $sql) && mysqli_query($conexion, $sql2) && mysqli_query($conexion, $sql3) && mysqli_query($conexion, $sql4) && mysqli_query($conexion, $sql5) && mysqli_query($conexion, $sql6)) {
            header("Location: ../J3Adm.php?mensaje=Datos actualizados correctamente");
        } else {
            header("Location: ../J3Adm.php?mensaje=Error al actualizar datos en la base de datos");
        }
    } else {
        header("Location: ../J3Adm.php?mensaje=Datos incompletos en el formulario");
    }
} else {
    header("Location: ../J3Adm.php");
}
?>