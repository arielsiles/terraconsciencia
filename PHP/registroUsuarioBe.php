<?php

include "conexionBe.php";

$nombre_usuario = $_POST["nombre_usuario"];
$correo = $_POST["correo"];
$clave = $_POST["clave"];
$rol_id = 2;

$clave = hash('sha512', $clave);

$verificarCr = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' ");

if(mysqli_num_rows($verificarCr) > 0){
    echo'
        <script>
            alert("Correo ya registrado, pruebe uno distinto");
            window.location = "../SinLogin.php"
        </script>
    ';
    exit();
}

$verificarUsr = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nombre_usuario='$nombre_usuario' ");

if(mysqli_num_rows($verificarUsr) > 0){
    echo'
        <script>
            alert("Nombre de Usuario ya registrado, pruebe uno distinto");
            window.location = "../SinLogin.php"
        </script>
    ';
    exit();
}

mysqli_begin_transaction($conexion);

try {
    $query1 = "INSERT INTO perfil() VALUES()";
    mysqli_query($conexion, $query1);

    $id_perfil = mysqli_insert_id($conexion);

    $query2 = "INSERT INTO usuarios(id, nombre_usuario, correo, clave, rol_id) VALUES('$id_perfil', '$nombre_usuario','$correo','$clave','$rol_id')";
    mysqli_query($conexion, $query2);

    mysqli_commit($conexion);

    echo'
        <script>
            alert("Usuario Registrado Exitosamente Inicie Sesion Con Su Nombre de Usuario y Clave");
        </script>
       ';
       header("location: ../ConLogin.php");
} catch (mysqli_sql_exception $e) {
    echo "Error en la consulta SQL: " . mysqli_error($conexion);
} catch (Exception $e) {
    mysqli_rollback($conexion);

    echo'
        <script>
            alert("Error, vuelva a intentarlo");
            window.location = "../SinLogin.php"
        </script>
       ';
}

mysqli_close($conexion);
?>
