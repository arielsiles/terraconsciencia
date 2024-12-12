<?php
    include './PHP/palabra.php';
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
    <div class="contenedorAh">
    <form action="./PHP/actAv.php" method="POST">
        <h2>Formulario de Preguntas y Respuestas</h2>
        <?php
        for ($i = 1; $i <= 10; $i++) {
            echo "<div>";
            echo "<h3>Pregunta $i:</h3>";
            
            echo "<label for='pregunta$i'>Pregunta:</label>";
            echo "<input type='text' id='pregunta$i' name='pregunta[]' required maxlength='50'>";
            
            echo "<label for='respuestaBuena$i'>Respuesta Buena:</label>";
            echo "<input type='text' id='respuestaBuena$i' name='respuestaBuena[]' required maxlength='50'>";
            
            echo "<label for='respuestaMala$i'>Respuesta Mala:</label>";
            echo "<input type='text' id='respuestaMala$i' name='respuestaMala[]' required maxlength='50'>";
            echo "</div>";
        }
        ?>
        <input type="submit" value="Enviar Respuestas">
    </form>
        <button onclick="resetCountersAv()">Reestablecer</button>
    </div>
    <a class="return" href="J6.php">
        Volver 
    </a>
    <script src="./JS/resetCountersAv.js"></script>
</body>
</html>