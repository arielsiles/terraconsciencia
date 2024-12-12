<?php
    require "./PHP/direcciones.php";
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
    <div class="contenedor">
        <h1>Haga click sobre el apartado a editar: </h1>
        <h2>Una vez modificado haga click en bien y se guardaran los cambios.</h2>
        <div class="pantalla">
            <form action="PHP/subidaCl.php" method="POST" enctype="multipart/form-data" class="main">
                <input type="file" name="imagenPortada" accept="image/*" style="display:none;" id="portada" onchange="javascript:previewImage(event, '#previewImg')" required>
                <label for="portada">
                    <img src="<?php echo $rutaImagen; ?>" alt="" width="100%" height="100%" id="previewImg" >
                </label>
                <input type="submit" value="Enviar" style="display:none;" id="enviarPortada">
                <label for="enviarPortada" class="botonPortada"><i class="fas fa-thumbs-up"></i></label>
            </form>
            <div class="lado">
                <p>Noticias</p>
                <form action="PHP/subidaCl.php" method="POST" enctype="multipart/form-data" class="caja">
                <input type="file" name="imagenNoticias" accept="image/*" style="display:none;" id="noticias" onchange="javascript:previewImage(event, '#previewImgNt')" required>
                <label for="noticias">
                    <img src="<?php echo $rutaImagen2; ?>" alt="" width="100%" height="100%" id="previewImgNt">
                </label>
                <input type="submit" value="Enviar" style="display:none;" id="enviarNt">
                <label for="enviarNt" class="botonCaja"><i class="fas fa-thumbs-up"></i></label>
                </form>
                <p>Publicaciones</p> 
                <form action="PHP/subidaCl.php" method="POST" enctype="multipart/form-data" class="caja">
                <input type="file" name="imagenPublicaciones" accept="image/*" style="display:none;" id="publicaciones" onchange="javascript:previewImage(event, '#previewImgPb')" required>
                <label for="publicaciones">
                    <img src="<?php echo $rutaImagen3; ?>" alt="" width="100%" height="100%" id="previewImgPb">
                </label>
                <input type="submit" value="Enviar" style="display:none;" id="enviarPb">
                <label for="enviarPb" class="botonCaja"><i class="fas fa-thumbs-up"></i></label>
                </form>
                <p>Trivias</p>
                <form action="PHP/subidaCl.php" method="POST" enctype="multipart/form-data" class="caja">
                <input type="file" name="imagenTrivias" accept="image/*" style="display:none;" id="trivias" onchange="javascript:previewImage(event, '#previewImgTr')" required>
                <label for="trivias">
                    <img src="<?php echo $rutaImagen4; ?>" alt="" width="100%" height="100%" id="previewImgTr">
                </label>
                <input type="submit" value="Enviar" style="display:none;" id="enviarTr">
                <label for="enviarTr" class="botonCaja"><i class="fas fa-thumbs-up"></i></label>
                </form>
            </div>
        </div>
        <h2>Edita los mensajes de los popups: </h2>
        <h3>Maximo 130 caracteres.</h3>
        <form action="./PHP/subidaCl.php" method="POST" class="popups">
            <p>Modal 1:</p>
            <input type="text" class="modal" name="modif1" placeholder="<?php echo $descripciones[0]?>">
            <p>Modal 2:</p>
            <input type="text" class="modal" name="modif2" placeholder="<?php echo $descripciones[1]?>">
            <p>Modal 3:</p>
            <input type="text" class="modal" name="modif3" placeholder="<?php echo $descripciones[2]?>">
            <p>Modal 4:</p>
            <input type="text" class="modal" name="modif4" placeholder="<?php echo $descripciones[3]?>">
            <p>Modal 5:</p>
            <input type="text" class="modal" name="modif5" placeholder="<?php echo $descripciones[4]?>">
            <p>Modal 6:</p>
            <input type="text" class="modal" name="modif6" placeholder="<?php echo $descripciones[5]?>">
            <input type="submit" value="Guardar modificaciones" id="subModPp" style="display: none;">
            <label for="subModPp" class="botonPortada" ><i class="fas fa-thumbs-up"></i></label>
        </form>
        <a class="return" href="ConLoginAdm.php">
            Volver 
        </a>
    </div>
    <script src="./JS/preview.js"></script>
</body>
</html>