<?php
    require "PHP/popups.php";
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
        <link rel="stylesheet" href="assets/CSS/styleEdicion.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Belanosima&family=Pacifico&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Happy+Monkey&display=swap" rel="stylesheet">
</head>
<body>
    <div class="contenedorTr">
        <h2>Edita los mensajes de los popups: </h2>
        <h3>Maximo 130 caracteres.</h3>
        <form action="PHP/subidaCl.php" method="POST" class="popups">
            <p>Modal 1:</p>
            <input type="text" class="modal" name="modif19" placeholder="<?php echo $descripciones[18]?>">
            <p>Modal 2:</p>
            <input type="text" class="modal" name="modif20" placeholder="<?php echo $descripciones[19]?>">
            <p>Modal 3:</p>
            <input type="text" class="modal" name="modif21" placeholder="<?php echo $descripciones[20]?>">
            <p>Modal 4:</p>
            <input type="text" class="modal" name="modif22" placeholder="<?php echo $descripciones[21]?>">
            <p>Modal 5:</p>
            <input type="text" class="modal" name="modif23" placeholder="<?php echo $descripciones[22]?>">
            <p>Modal 6:</p>
            <input type="text" class="modal" name="modif24" placeholder="<?php echo $descripciones[23]?>">
            <input type="submit" value="Modificar" id="subModPp" style="display: none;">
            <label for="subModPp" class="botonPortada" ><i class="fas fa-thumbs-up"></i></label>
        </form>
        <button id="resetButton">Restablecer puntos</button>
        <a class="return" href="TriviasAdm.php">
            Volver 
        </a>
    </div>
</body>
<script src="JS/resetPoints.js"></script>
</html>