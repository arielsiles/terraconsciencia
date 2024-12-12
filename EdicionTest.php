<?php
    require "./PHP/popups.php";
    session_start();
    $roles_permitidos = ['Administrador'];
    if(!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], $roles_permitidos)){
        header("Location: ConLogin.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
        <title>Edicion</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="shortcut icon" href="IMG/Icono.ico" width="50px">
        <link rel="stylesheet" href="../assets/CSS/styleEdicion.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Belanosima&family=Pacifico&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
</head>
<body>
    <div class="contenedorJgs">
        <h1>Edita el Test: </h1>
        <form action="./PHP/edicionJgs.php" method="post" class="envioTest">
            <h2>Pregunta 1: </h2>
            <input type="text" placeholder= "Ingrese la pregunta" name="pregunta1">
            <p>Respuesta 1:</p>
            <input type="text" placeholder= "Opcion a" name="opc1">
            <p>Respuesta 2: </p>
            <input type="text" placeholder= "Opcion b" name="opc2">
            <p>Respuesta 3: </p>
            <input type="text" placeholder= "Opcion c" name="opc3">
            <p>Ingrese la opcion correcta: </p>
            <input type="text" name="opcV1" id="" maxlength="1" placeholder="(a) (b) (c)">
            <br><br>
            <h2>Pregunta 2: </h2>
            <input type="text" placeholder= "Ingrese la pregunta" name="pregunta2">
            <p>Respuesta 1:</p>
            <input type="text" placeholder= "Opcion a" name="opc4">
            <p>Respuesta 2: </p>
            <input type="text" placeholder= "Opcion b" name="opc5">
            <p>Respuesta 3: </p>
            <input type="text" placeholder= "Opcion c" name="opc6">
            <p>Ingrese la opcion correcta: </p>
            <input type="text" name="opcV2" id="" maxlength="1" placeholder="(a) (b) (c)">
            <br><br>
            <h2>Pregunta 3: </h2>
            <input type="text" placeholder= "Ingrese la pregunta" name="pregunta3">
            <p>Respuesta 1:</p>
            <input type="text" placeholder= "Opcion a" name="opc7">
            <p>Respuesta 2: </p>
            <input type="text" placeholder= "Opcion b" name="opc8">
            <p>Respuesta 3: </p>
            <input type="text" placeholder= "Opcion c" name="opc9">
            <p>Ingrese la opcion correcta: </p>
            <input type="text" name="opcV3" id="" maxlength="1" placeholder="(a) (b) (c)">
            <br><br>
            <h2>Pregunta 4: </h2>
            <input type="text" placeholder= "Ingrese la pregunta" name="pregunta4">
            <p>Respuesta 1:</p>
            <input type="text" placeholder= "Opcion a" name="opc10">
            <p>Respuesta 2: </p>
            <input type="text" placeholder= "Opcion b" name="opc11">
            <p>Respuesta 3: </p>
            <input type="text" placeholder= "Opcion c" name="opc12">
            <p>Ingrese la opcion correcta: </p>
            <input type="text" name="opcV4" id="" maxlength="1" placeholder="(a) (b) (c)">
            <br><br>
            <h2>Pregunta 5: </h2>
            <input type="text" placeholder= "Ingrese la pregunta" name="pregunta5">
            <p>Respuesta 1:</p>
            <input type="text" placeholder= "Opcion a" name="opc13">
            <p>Respuesta 2: </p>
            <input type="text" placeholder= "Opcion b" name="opc14">
            <p>Respuesta 3: </p>
            <input type="text" placeholder= "Opcion c" name="opc15">
            <p>Ingrese la opcion correcta: </p>
            <input type="text" name="opcV5" id="" maxlength="1" placeholder="(a) (b) (c)">
            <br><br>
            <h2>Pregunta 6: </h2>
            <input type="text" placeholder= "Ingrese la pregunta" name="pregunta6">
            <p>Respuesta 1:</p>
            <input type="text" placeholder= "Opcion a" name="opc16">
            <p>Respuesta 2: </p>
            <input type="text" placeholder= "Opcion b" name="opc17">
            <p>Respuesta 3: </p>
            <input type="text" placeholder= "Opcion c" name="opc18">
            <p>Ingrese la opcion correcta: </p>
            <input type="text" name="opcV6" id="" maxlength="1" placeholder="(a) (b) (c)">
            <br><br>
            <h2>Pregunta 7: </h2>
            <input type="text" placeholder= "Ingrese la pregunta" name="pregunta7">
            <p>Respuesta 1:</p>
            <input type="text" placeholder= "Opcion a" name="opc19">
            <p>Respuesta 2: </p>
            <input type="text" placeholder= "Opcion b" name="opc20">
            <p>Respuesta 3: </p>
            <input type="text" placeholder= "Opcion c" name="opc21">
            <p>Ingrese la opcion correcta: </p>
            <input type="text" name="opcV7" id="" maxlength="1" placeholder="(a) (b) (c)">
            <br><br>
            <h2>Pregunta 8: </h2>
            <input type="text" placeholder= "Ingrese la pregunta" name="pregunta8">
            <p>Respuesta 1:</p>
            <input type="text" placeholder= "Opcion a" name="opc22">
            <p>Respuesta 2: </p>
            <input type="text" placeholder= "Opcion b" name="opc23">
            <p>Respuesta 3: </p>
            <input type="text" placeholder= "Opcion c" name="opc24">
            <p>Ingrese la opcion correcta: </p>
            <input type="text" name="opcV8" id="" maxlength="1" placeholder="(a) (b) (c)">
            <br><br>
            <h2>Pregunta 9: </h2>
            <input type="text" placeholder= "Ingrese la pregunta" name="pregunta9">
            <p>Respuesta 1:</p>
            <input type="text" placeholder= "Opcion a" name="opc25">
            <p>Respuesta 2: </p>
            <input type="text" placeholder= "Opcion b" name="opc26">
            <p>Respuesta 3: </p>
            <input type="text" placeholder= "Opcion c" name="opc27">
            <p>Ingrese la opcion correcta: </p>
            <input type="text" name="opcV9" id="" maxlength="1" placeholder="(a) (b) (c)" >
            <br><br>
            <h2>Pregunta 10: </h2>
            <input type="text" placeholder= "Ingrese la pregunta" name="pregunta10">
            <p>Respuesta 1:</p>
            <input type="text" placeholder= "Opcion a" name="opc28">
            <p>Respuesta 2: </p>
            <input type="text" placeholder= "Opcion b" name="opc29">
            <p>Respuesta 3: </p>
            <input type="text" placeholder= "Opcion c" name="opc30">
            <p>Ingrese la opcion correcta: </p>
            <input type="text" name="opcV10" id="" maxlength="1" placeholder="(a) (b) (c)">
            <br><br>
            <input type="submit" value="Subir Test">
        </form>
        <button id="resetButton" onclick="resetCounters()">Restablecer contadores</button>
        <a class="return" href="J2.php">
            Volver 
        </a>
    </div>
    <script src="./JS/resetCounters.js"></script>
</body>
</html>