<?php
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
    <div class="contenedorFV">
        <form action="./PHP/actFV.php" method="post">
        <h1>Sube el texto a leerse: </h1>
        <h2>Titulo</h2>
        <input type="text" name="titAf" id="titAf" required>
        <h2>Contenido</h2>
        <input type="text" name="contAf" id="contAf" required>
        <h1>Establece las afirmaciones del Falso o Verdadero</h1>
        <h2>Afirmacion 1</h2>
        <input type="text" name="af1" id="af1" required>
        <h3>Respuesta F o V</h3>
        <input type="text" maxlength="1" placeholder="F o V" required name="r1" >
        <h2>Afirmacion 2</h2>
        <input type="text" name="af2" id="af2" required>
        <h3>Respuesta F o V</h3>
        <input type="text" maxlength="1" placeholder="F o V" required name="r2" >
        <h2>Afirmacion 3</h2>
        <input type="text" name="af3" id="af3" required>
        <h3>Respuesta F o V</h3>
        <input type="text" maxlength="1" placeholder="F o V" required name="r3" >
        <h2>Afirmacion 4</h2>
        <input type="text" name="af4" id="af4" required>
        <h3>Respuesta F o V</h3>
        <input type="text" maxlength="1" placeholder="F o V" required name="r4" >
        <h2>Afirmacion 5</h2>
        <input type="text" name="af5" id="af5" required>
        <h3>Respuesta F o V</h3>
        <input type="text" maxlength="1" placeholder="F o V" required name="r5" >
        <br>
        <input type="submit" value="Enviar">
        </form>
        <button onclick="actualizarContadorFV()">Reestablecer</button>
    </div>
    <script src="./JS/resetCountersFV.js"></script>
</body>
</html>