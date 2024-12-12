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
        <form action="./PHP/actAh.php" method="POST">
        <h1>Establece las Palabras a mostrarse de forma aleatoria</h1>
        <h2>Palabra 1</h2>
        <input type="text" name="plb1" placeholder="<?php echo $palabra[0] ?>">
        <h2>Palabra 2</h2>
        <input type="text" name="plb2" placeholder="<?php echo $palabra[1] ?>">
        <h2>Palabra 3</h2>
        <input type="text" name="plb3" placeholder="<?php echo $palabra[2] ?>">
        <h2>Palabra 4</h2>
        <input type="text" name="plb4" placeholder="<?php echo $palabra[3] ?>">
        <h2>Palabra 5</h2>
        <input type="text" name="plb5" placeholder="<?php echo $palabra[4] ?>">
        <br>
        <input type="submit" value="Actualizar">
        </form>
        <button onclick="actualizarContadorFV()">Reestablecer</button>
    </div>
    <a class="return" href="J4.php">
        Volver 
    </a>
    <script src="./JS/resetCountersFV.js"></script>
</body>
</html>