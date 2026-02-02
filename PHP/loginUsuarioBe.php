<?php

    include 'conexionBe.php';

    $nombre_usuario = $_POST["nombre_usuario"];
    $clave= $_POST["clave"];

    //Desencriptado
    $clave = hash('sha512', $clave);

    $validacion = mysqli_query($conexion, "SELECT u.id, u.correo, u.clave, u.fecha, u.activo, c.descripcion as rol FROM usuarios u left join cargo c on u.rol_id = c.id WHERE nombre_usuario = '$nombre_usuario'
                  AND clave = '$clave'");
    $row = $validacion->fetch_assoc();
    if(mysqli_num_rows($validacion) > 0){
        // Verificar si la cuenta está activada
        // Si activo es NULL (usuarios antiguos) o activo=1, permitir acceso
        if (isset($row['activo']) && $row['activo'] == 0) {
            echo'
            <script>
                alert("Debes confirmar tu correo electronico antes de iniciar sesion. Revisa tu bandeja de entrada.");
                window.location = "../SinLogin.php"
            </script>
            ';
            exit();
        }

        session_start();
        $_SESSION['usuario'] = $nombre_usuario;
        $_SESSION['rol'] = $row['rol'];
        $_SESSION['id'] = $row['id'];
        header("location: ../ConLogin.php");
        exit();
    }else{
        echo'
        <script>
            alert("Usuario o clave incorrecta, verifique nuevamente");
            window.location = "../SinLogin.php"
        </script>
        ';
        exit();
    }

?>
